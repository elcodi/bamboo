<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
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

namespace Elcodi\Store\CoreBundle\Behat;

use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Input\ArrayInput;

use Elcodi\Store\CoreBundle\Behat\abstracts\AbstractElcodiContext;

/**
 * Class DoctrineContext
 */
class DoctrineContext extends AbstractElcodiContext
{
    /**
     * @BeforeScenario
     */
    public function prepare(BeforeScenarioScope $scope)
    {
        gc_collect_cycles();

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

        $this->application->run(new ArrayInput(array(
            'command'          => 'doctrine:database:drop',
            '--env'            => 'test',
            '--no-interaction' => true,
            '--force'          => true,
            '--quiet'          => true,
        )));

        if ($doctrineConnection->isConnected()) {
            $doctrineConnection->close();
        }

        $this->application->run(new ArrayInput(array(
            'command'          => 'doctrine:database:create',
            '--env'            => 'test',
            '--no-interaction' => true,
            '--quiet'          => true,
        )));

        $this->application->run(new ArrayInput(array(
            'command'          => 'doctrine:schema:create',
            '--env'            => 'test',
            '--no-interaction' => true,
            '--quiet'          => true,
        )));

        $this->application->run(new ArrayInput(array(
            'command'          => 'doctrine:fixtures:load',
            '--env'            => 'test',
            '--no-interaction' => false,
            '--fixtures'       => $this->kernel->getRootDir().'/../src/Elcodi/Fixtures',
            '--quiet'          => true,
        )));

        $this->application->run(new ArrayInput(array(
            'command'          => 'elcodi:templates:load',
            '--env'            => 'test',
            '--no-interaction' => false,
            '--quiet'          => true,
        )));

        $this->application->run(new ArrayInput(array(
            'command'          => 'elcodi:templates:enable',
            'template'         => 'StoreTemplateBundle',
            '--env'            => 'test',
            '--no-interaction' => false,
            '--quiet'          => true,
        )));

        $this->application->run(new ArrayInput(array(
            'command'          => 'elcodi:plugins:load',
            '--env'            => 'test',
            '--no-interaction' => false,
            '--quiet'          => true,
        )));
    }

    /**
     * @AfterScenario
     */
    public function cleanDB(AfterScenarioScope $scope)
    {
        $this
            ->getContainer()
            ->get('doctrine')
            ->getConnection()
            ->close();

        $this->application->run(new ArrayInput(array(
            'command'          => 'doctrine:database:drop',
            '--env'            => 'test',
            '--no-interaction' => true,
            '--force'          => true,
            '--quiet'          => true,
        )));
    }
}
