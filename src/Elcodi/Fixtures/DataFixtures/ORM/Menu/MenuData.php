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
 */

namespace Elcodi\Fixtures\DataFixtures\ORM\Menu;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Menu\Factory\MenuFactory;
use Elcodi\Component\Menu\Factory\NodeFactory;

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
        $menuConfiguration = $this->parseYaml(dirname(__FILE__) . '/menus.yml');

        /**
         * Menu nodes population
         */

        /**
         * @var ObjectManager $menuNodeObjectManager
         * @var NodeFactory   $menuNodeFactory
         * @var array         $menuNodeEntities
         */
        $menuNodeObjectManager = $this->get('elcodi.object_manager.menu_node');
        $menuNodeFactory = $this->get('elcodi.factory.menu_node');
        $menuNodeEntities = [];

        foreach ($menuConfiguration['menu_nodes'] as $menuNodeAlias => $menuNodeData) {

            $menuNode = $menuNodeFactory
                ->create()
                ->setName($menuNodeData['name'])
                ->setCode($menuNodeData['code'])
                ->setUrl($menuNodeData['url'])
                ->setEnabled((boolean) $menuNodeData['enabled']);

            if (is_array($menuNodeData['subnodes'])) {

                foreach ($menuNodeData['subnodes'] as $subnode) {

                    $menuNode->addSubnode(
                        $this->getReference('menu-node-' . $subnode)
                    );
                }
            }

            $this->setReference('menu-node-' . $menuNodeAlias, $menuNode);
            $menuNodeObjectManager->persist($menuNode);
            $menuNodeEntities[] = $menuNode;
        }

        $menuNodeObjectManager->flush($menuNodeEntities);

        /**
         * Menus population
         */

        /**
         * @var ObjectManager $menuObjectManager
         * @var MenuFactory   $menuFactory
         * @var array         $menuEntities
         */
        $menuObjectManager = $this->get('elcodi.object_manager.menu');
        $menuFactory = $this->get('elcodi.factory.menu');
        $menuEntities = [];

        foreach ($menuConfiguration['menus'] as $menuAlias => $menuData) {

            $menu = $menuFactory
                ->create()
                ->setCode($menuData['code'])
                ->setDescription($menuData['description'])
                ->setEnabled((boolean) $menuData['enabled']);

            if (is_array($menuData['subnodes'])) {

                foreach ($menuData['subnodes'] as $subnode) {

                    $menu->addSubnode(
                        $this->getReference('menu-node-' . $subnode)
                    );
                }
            }

            $this->setReference('menu-' . $menuData['code'], $menu);
            $menuObjectManager->persist($menu);
            $menuEntities[] = $menu;
        }

        $menuObjectManager->flush($menuEntities);
    }
}
