<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class ElcodiInstallCommand
 */
class ElcodiInstallCommand extends Command
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
                'Countries to be loaded during the installation. By default, Spain will be loaded',
                ['spain']
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
        return $this->installElcodi(
            $output,
            $input->getOption('country')
        );
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
            ->executeCommand('doctrine:database:create')
            ->executeCommand('doctrine:schema:create')
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
     *
     * @return $this Self object
     */
    private function executeCommand($command)
    {
        $this
            ->getApplication()
            ->run(new ArrayInput([
                'command'          => $command,
                '--no-interaction' => true,
            ]));

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
     * Load country
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
        $formatterHelper = $this->getHelper('formatter');
        $rootDir = $this
            ->kernel
            ->getRootDir();

        $finder = new Finder();
        $finder
            ->in($rootDir . '/../vendor/elcodi/elcodi/src/Elcodi/Bundle/GeoBundle/DataFixtures/ORM/Dumps')
            ->name($country . '.sql');

        foreach ($finder as $file) {
            $content = $file->getContents();

            $stmt = $this
                ->locationEntityManager
                ->getConnection()
                ->prepare($content);

            $stmt->execute();

            $output->writeln($formatterHelper->formatSection(
                'OK',
                'Country ' . $country . ' installed'
            ));
        }

        return $this;
    }
}
