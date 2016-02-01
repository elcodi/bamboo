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
        $menu = $this
            ->container
            ->get('elcodi.manager.menu')
            ->loadMenuByCode('admin');

        return [
            'menu'  => $menu,
            'route' => $this
                ->get('request_stack')
                ->getMasterRequest()
                ->attributes
                ->get('_route'),
        ];
    }
}
