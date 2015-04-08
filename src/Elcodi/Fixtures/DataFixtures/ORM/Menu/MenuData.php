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

namespace Elcodi\Fixtures\DataFixtures\ORM\Menu;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Config\Definition\Processor;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\SubnodesAwareInterface;

/**
 * Class MenuData
 *
 * Fixtures for Bamboo menus
 */
class MenuData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $config = $this->loadConfiguration();

        $this->processMenu($config);
    }

    /**
     * Create root Menu nodes from configuration
     *
     * @param array $config Configuration
     */
    protected function processMenu(array $config)
    {
        $nodes = [];
        $director = $this->get('elcodi.director.menu');

        foreach ($config as $menuName => $menuConfig) {
            $node = $director
                ->create()
                ->setCode($menuConfig['code'])
                ->setDescription($menuConfig['description'])
                ->setEnabled($menuConfig['enabled']);

            $this->processChildren($node, $menuConfig['children']);

            $nodes[] = $node;
        }

        $director->save($nodes);
    }

    /**
     * Create a node from configuration
     *
     * @param string $name   Name of the node
     * @param array  $config Node configuration
     *
     * @return NodeInterface
     */
    protected function createSubnode($name, array $config)
    {
        /**
         * @var NodeInterface $node
         */
        $node = $this
            ->get('elcodi.factory.menu_node')
            ->create();

        $node
            ->setName($name)
            ->setCode($config['code'])
            ->setUrl($config['url'])
            ->setActiveUrls($config['active_urls'])
            ->setEnabled($config['enabled']);

        if (!empty($config['children'])) {
            $this->processChildren($node, $config['children']);
        }

        return $node;
    }

    /**
     * Process menu nodes children of a configuration
     *
     * @param SubnodesAwareInterface $parent Parent node
     * @param array                  $config Menu configuration
     */
    protected function processChildren(SubnodesAwareInterface $parent, array $config)
    {
        foreach ($config as $childName => $childConfig) {
            $child = $this->createSubnode($childName, $childConfig);
            $parent->addSubnode($child);
        }
    }

    /**
     * Load fixtures from disk with configuration
     *
     * @return array
     */
    protected function loadConfiguration()
    {
        $config = $this->parseYaml(__DIR__.'/menus.yml');

        $configuration = new Configuration('menu');
        $processor = new Processor();

        return $processor->processConfiguration($configuration, [ $config ]);
    }
}
