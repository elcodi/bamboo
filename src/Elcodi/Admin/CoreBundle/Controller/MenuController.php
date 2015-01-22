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
            ->get('elcodi.core.menu.service.menu_manager')
            ->loadMenuByCode('admin');

        $currentRoute = $this
            ->get('request_stack')
            ->getMasterRequest()
            ->get('_route');

        /*
         * We need to add some information about the selected menu,
         * which is a simple comparison between current route in the
         * master request and the route from the menu
         */
        foreach ($root as &$menuItems) {

            $menuItems['active'] = ($currentRoute == $menuItems['url']);

            if (count($menuItems['subnodes'])) {

                foreach ($menuItems['subnodes'] as &$menuItem) {
                    $menuItem['active'] = $currentRoute == $menuItem['url'];

                    if ($menuItem['active']) {
                        $menuItems['active'] = true;
                    }
                }
            }
        }

        return [
            'menu_items' => $root
        ];
    }
}
