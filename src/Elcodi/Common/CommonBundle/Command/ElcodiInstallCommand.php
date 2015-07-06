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
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\OutputInterface;
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
                sprintf(
                    'Countries to be loaded during the installation. Available countries: %s',
                    implode(', ', $this->getInstallableCountries())
                ),
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
        $countries = $input->getOption('country');
        foreach ($countries as $country) {
            if (!in_array($country, $this->getInstallableCountries())) {
                throw new RuntimeException(sprintf(
                    "Country %s not found. Available countries: %s.",
                    $country,
                    implode(', ', $this->getInstallableCountries())
                ));
            }
        }

        $countries = array_unique(
            array_merge(
                $countries,
                ['spain']
            )
        );

        return $this->installElcodi(
            $output,
            $countries
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
        $formatterHelper = $this->getHelper('formatter');
        if (!in_array($country, $this->getInstallableCountries())) {
            $output->writeln($formatterHelper->formatSection(
                'FAIL',
                'Country ' . $country . ' not found',
                'error'
            ));
        }

        $url = "https://raw.githubusercontent.com/elcodi/LocationDumps/master/" . $country . ".sql";
        $content = file_get_contents($url);
        if ($content) {
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

    /**
     * Get available installation countries
     *
     * @return array Installable countries
     */
    private function getInstallableCountries()
    {
        return [
            'andorra',
            'austria',
            'belgium',
            'denmark',
            'finland',
            'france',
            'germany',
            'italy',
            'spain',
            'switzerland',
            'united_kingdom',
            'poland',
        ];
    }
}
