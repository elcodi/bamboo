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

namespace Elcodi\Admin\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MenuController
 */
class MenuController extends Controller
{
    /**
     * Subrequest rendering left side menu
     *
     * @Route(
     *      path = "components/menu/side",
     *      name = "admin_menu_side"
     * )
     * @Template("@AdminCore/Navs/side.html.twig")
     *
     * @return array
     */
    public function sideNavAction()
    {
        $root = $this
            ->container
            ->get('elcodi.manager.menu')
            ->loadMenuByCode('admin');

        $this->appendPluginMenus($root);
        $this->addMenuExtraData($root);

        return [
            'menu_items' => $root,
        ];
    }

    /**
     * This method adds the extra data like the selected page or the item
     * badges.
     *
     * @param array $pluginsMenu Plugins menu built
     */
    protected function addMenuExtraData(array &$pluginsMenu)
    {
        $currentRoute = $this
            ->get('request_stack')
            ->getMasterRequest()
            ->get('_route');

        $selectActiveMenu = function (&$item) use ($currentRoute) {
            if (in_array($currentRoute, $item['activeUrls'])) {
                $item['active'] = true;
            }
        };

        $expandParentMenu = function (&$item) use ($currentRoute) {
            $item['expanded'] = false;
            foreach ($item['subnodes'] as $subnode) {
                if (in_array($currentRoute, $subnode['activeUrls'])) {
                    $item['expanded'] = true;
                }
            }
        };

        $pendingOrders      = $this
            ->get('elcodi.repository.order')
            ->getNotShippedOrders();
        $pendingOrdersCount = count($pendingOrders);

        $addOrdersPendingBadge = function (&$item) use ($pendingOrdersCount) {
            if ('admin_order_list' == $item['url']) {
                $item['badge'] = $pendingOrdersCount;
            }
        };

        $this->updateMenuItem(
            $pluginsMenu,
            [
                $selectActiveMenu,
                $expandParentMenu,
                $addOrdersPendingBadge,
            ]
        );
    }

    /**
     * Append the plugin pages
     *
     * @param array $pluginsMenu Plugins menu built
     *
     * @return $this Self Object
     */
    protected function appendPluginMenus(array &$pluginsMenu)
    {
        $plugins = $this
            ->get('elcodi.manager.configuration')
            ->get('store.plugins');

        foreach ($plugins as $plugin) {
            if (
                !$plugin['enabled'] ||
                !$plugin['visible']
            ) {
                continue;
            }

            $menu = $this
                ->get('elcodi.factory.menu_node')
                ->create()
                ->setName($plugin['name'])
                ->setCode($plugin['fa_icon'])
                ->setUrl($plugin['configuration_route']);

            $pluginsMenu[] = $this
                ->get('elcodi.manager.menu')
                ->hydrateNode($menu);
        }

        return $this;
    }

    /**
     * Updates the received menu applying the received closures, each closure
     * receives all the items to be checked and updated.
     *
     * The received closures will be called with an item menu as a parameter
     *
     * @param array      $pluginsMenu The plugins menu
     * @param \Closure[] $closures    The closures to apply
     */
    protected function updateMenuItem(
        array &$pluginsMenu,
        array $closures
    ) {
        foreach ($pluginsMenu as &$menuItems) {
            foreach ($closures as $closure) {
                $closure($menuItems);
            }

            if (count($menuItems['subnodes'])) {
                foreach ($menuItems['subnodes'] as &$menuItem) {
                    foreach ($closures as $closure) {
                        $closure($menuItem);
                    }
                }
            }
        }
    }
}
