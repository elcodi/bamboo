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

namespace Elcodi\Fixtures\DataFixtures\ORM\Configuration;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * Class ConfigurationData
 */
class ConfigurationData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $configurations = $this->parseYaml(dirname(__FILE__) . '/configuration.yml');

        /**
         * @var ObjectManager $configurationObjectManager
         * @var array         $configurationEntities
         */
        $configurationObjectManager = $this->get('elcodi.object_manager.configuration');
        $configurationFactory = $this->get('elcodi.factory.configuration');
        $configurationEntities = [];

        foreach ($configurations as $configuration) {
            $configuration = $configurationFactory
                ->create()
                ->setKey($configuration['key'])
                ->setNamespace($configuration['namespace'])
                ->setName($configuration['name'])
                ->setType($configuration['type'])
                ->setValue($configuration['value']);

            $configurationObjectManager->persist($configuration);
            $configurationEntities[] = $configuration;
        }

        $configurationObjectManager->flush($configurationEntities);
    }
}
