<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Common\CommonBundle\Command;

use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use Elcodi\Component\Core\Command\Abstracts\AbstractElcodiCommand;

/**
 * Class ElcodiInstallCommand
 */
class ElcodiInstallCommand extends AbstractElcodiCommand
{
    /**
     * @var KernelInterface
     *
     * Kernel
     */
    private $kernel;

    /**
     * @var ObjectManager
     *
     * Location entity manager
     */
    private $locationEntityManager;

    /**
     * Construct
     *
     * @param KernelInterface $kernel                Kernel
     * @param ObjectManager   $locationEntityManager Location entity manager
     */
    public function __construct(
        KernelInterface $kernel,
        ObjectManager $locationEntityManager
    ) {
        parent::__construct();

        $this->kernel = $kernel;
        $this->locationEntityManager = $locationEntityManager;
    }

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:install')
            ->setDescription('Installs Elcodi in your dev environment')
            ->addOption(
                'country',
                'c',
                InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL,
                'Countries to be loaded during the installation',
                ['ES']
            );
    }

    /**
     * Executes the current command.
     *
     * This method is not abstract because you can use this class
     * as a concrete class. In this case, instead of defining the
     * execute() method, you set the code to execute by passing
     * a Closure to the setCode() method.
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return null|int null or 0 if everything went fine, or an error code
     *
     * @throws \LogicException When this abstract method is not implemented
     *
     * @see setCode()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this
            ->startCommand($output)
            ->installElcodi(
                $output,
                $input->getOption('country')
            )
            ->finishCommand($output);
    }

    /**
     * Install Elcodi environment
     *
     * @param OutputInterface $output    Output
     * @param array           $countries Countries
     *
     * @return $this Self object
     */
    private function installElcodi(
        OutputInterface $output,
        array $countries
    ) {
        $this
            ->getApplication()
            ->setAutoExit(false);

        $this
            ->executeCommand('doctrine:database:create', [
                '--if-not-exists' => true,
            ])
            ->executeCommand('doctrine:schema:drop', [
                '--force' => true,
                '--full-database' => true,
            ])
            ->executeCommand('doctrine:migrations:status')
            ->executeCommand('doctrine:migrations:migrate')
            ->loadCommonFixtures()
            ->loadLocations($output, $countries)
            ->executeCommand('elcodi:plugins:load')
            ->executeCommand('assets:install')
            ->executeCommand('assetic:dump');

        return $this;
    }

    /**
     * Execute a command
     *
     * @param string $command Command
     * @param array  $options Command options
     *
     * @return $this Self object
     */
    private function executeCommand($command, array $options = [])
    {
        $options = array_merge($options, [
            'command'          => $command,
            '--no-interaction' => true,
        ]);

        $this
            ->getApplication()
            ->run(new ArrayInput($options));

        return $this;
    }

    /**
     * Load common fixtures
     *
     * @return $this Self object
     *
     * @return $this Self object
     */
    private function loadCommonFixtures()
    {
        $rootDir = $this
            ->kernel
            ->getRootDir();

        $command =
            'doctrine:fixtures:load ' .
            '--fixtures=' . $rootDir . '/../src/Elcodi/Plugin/ ' .
            '--fixtures=' . $rootDir . '/../src/Elcodi/Fixtures ' .
            '--env=test ' .
            '--no-interaction ';

        $input = new StringInput($command);
        $this
            ->getApplication()
            ->run($input);

        return $this;
    }

    /**
     * Load countries
     *
     * @param OutputInterface $output    Output
     * @param array           $countries Countries
     *
     * @return $this Self object
     */
    private function loadLocations(
        OutputInterface $output,
        array $countries
    ) {
        foreach ($countries as $country) {
            $this
                ->loadLocation(
                    $output,
                    $country
                );
        }

        return $this;
    }

    /**
     * Load country from Elcodi files Repository
     *
     * @param OutputInterface $output  Output
     * @param string          $country Country name
     *
     * @return $this Self object
     */
    private function loadLocation(
        OutputInterface $output,
        $country
    ) {
        try {
            $url = "https://raw.githubusercontent.com/elcodi/LocationDumps/master/" . $country . ".sql";
            $content = file_get_contents($url);
            if ($content) {
                $stmt = $this
                    ->locationEntityManager
                    ->getConnection()
                    ->prepare($content);

                $stmt->execute();

                $this->printMessage(
                    $output,
                    'Elcodi',
                    'Country ' . $country . ' installed'
                );
            }
        } catch (Exception $e) {
            $this->printMessageFail(
                    $output,
                    'Elcodi',
                    'Country ' . $country . ' not installed'
                );
        }

        return $this;
    }
}
