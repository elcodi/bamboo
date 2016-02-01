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

namespace Elcodi\Bridge\BehatBridgeBundle;

use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\StringInput;

use Elcodi\Bridge\BehatBridgeBundle\Abstracts\AbstractElcodiContext;
use Elcodi\Component\Geo\Entity\Interfaces\LocationInterface;

/**
 * Class DoctrineContext
 */
class DoctrineContext extends AbstractElcodiContext
{
    /**
     * @var boolean
     *
     * Debug mode
     */
    protected $debug = false;

    /**
     * @BeforeScenario
     */
    public function prepare(BeforeScenarioScope $scope)
    {
        gc_collect_cycles();

        $this
            ->checkDoctrineConnection()
            ->executeCommand('doctrine:database:drop', [
                '--force' => true,
            ])
            ->checkDoctrineConnection()
            ->executeCommand('doctrine:database:create')
            ->executeCommand('doctrine:schema:create')
            ->loadCommonFixtures()
            ->loadLocationFixtures()
            ->executeCommand('elcodi:plugins:load')
            ->executeCommand('assets:install')
            ->executeCommand('assetic:dump');
    }

    /**
     * @AfterScenario
     */
    public function cleanDB(AfterScenarioScope $scope)
    {
        $container = $this->getContainer();

        $container
            ->get('doctrine')
            ->getConnection()
            ->close();

        // to remove if tests move from sqlite to *
        $params = $container
            ->get('doctrine')
            ->getConnection()
            ->getParams();

        unlink($params['path']);

        // to restore if tests move from sqlite to *
        // $this
        //     ->application
        //     ->run(new ArrayInput([
        //         'command'          => 'doctrine:database:drop',
        //         '--env'            => 'test',
        //         '--no-interaction' => true,
        //         '--force'          => true,
        //         '--quiet'          => true,
        //     ]));
    }

    /**
     * Prepare suite
     */
    public function prepareSuite(BeforeSuiteScope $scope)
    {
        $this
            ->executeCommand('assets:install')
            ->executeCommand('assetic:dump');
    }

    /**
     * Execute a command
     *
     * @param string $command    Command
     * @param array  $parameters Parameters
     *
     * @return $this Self object
     */
    private function executeCommand(
        $command,
        array $parameters = []
    ) {
        $definition = array_merge(
            [
                'command'          => $command,
                '--no-interaction' => true,
                '--env'            => 'test',
            ], $parameters
        );

        if (!$this->debug) {
            $definition['--quiet'] = true;
        }

        $this
            ->application
            ->run(new ArrayInput($definition));

        return $this;
    }

    /**
     * Check the doctrine connection
     *
     * @return $this Self object
     */
    private function checkDoctrineConnection()
    {
        /**
         * @var Connection $doctrineConnection
         */
        $doctrineConnection = $this
            ->getContainer()
            ->get('doctrine')
            ->getConnection();

        if ($doctrineConnection->isConnected()) {
            $doctrineConnection->close();
        }

        return $this;
    }

    /**
     * Load common fixtures
     *
     * @return $this Self object
     */
    private function loadCommonFixtures()
    {
        $command =
            'doctrine:fixtures:load ' .
            '--fixtures=src/Elcodi/Plugin ' .
            '--fixtures=src/Elcodi/Fixtures ' .
            '--env=test ' .
            '--no-interaction ';

        if (!$this->debug) {
            $command .= '--quiet ';
        }

        $input = new StringInput($command);
        $this
            ->application
            ->run($input);

        return $this;
    }

    /**
     * Load location fixtures
     *
     * @return $this Self object
     */
    private function loadLocationFixtures()
    {
        $locationDirector = $this
            ->getContainer()
            ->get('elcodi.director.location');

        /**
         * @var LocationInterface $locationBarcelonaCity
         */
        $locationBarcelonaCity = $locationDirector
            ->create()
            ->setId('ES_CT_B_Barcelona')
            ->setName('Barcelona')
            ->setCode('Barcelona')
            ->setType('city');
        $locationDirector->save($locationBarcelonaCity);

        /**
         * @var LocationInterface $locationBarcelonaProvince
         */
        $locationBarcelonaProvince = $locationDirector
            ->create()
            ->setId('ES_CT_B')
            ->setName('Barcelona')
            ->setCode('B')
            ->setType('province')
            ->addChildren($locationBarcelonaCity);
        $locationDirector->save($locationBarcelonaProvince);

        /**
         * @var LocationInterface $locationCatalunya
         */
        $locationCatalunya = $locationDirector
            ->create()
            ->setId('ES_CT')
            ->setName('Catalunya')
            ->setCode('CT')
            ->setType('state')
            ->addChildren($locationBarcelonaProvince);
        $locationDirector->save($locationCatalunya);

        /**
         * @var LocationInterface $locationSpain
         */
        $locationSpain = $locationDirector
            ->create()
            ->setId('ES')
            ->setName('Spain')
            ->setCode('ES')
            ->setType('country')
            ->addChildren($locationCatalunya);
        $locationDirector->save($locationSpain);

        return $this;
    }
}
