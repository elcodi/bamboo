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

namespace Elcodi\Admin\PluginBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;

/**
 * Class Controller for Plugins
 *
 * @Route(
 *      path = "/plugin",
 * )
 */
class PluginController extends AbstractAdminController
{
    /**
     * List plugins
     *
     * @return array Result
     *
     * @Route(
     *      path = "s",
     *      name = "admin_plugin_list",
     *      methods = {"GET"}
     * )
     * @Template
     */
    public function listAction()
    {
        $plugins = $this
            ->get('elcodi.plugin_manager')
            ->getPlugins();

        return [
            'plugins' => $plugins,
        ];
    }

    /**
     * Enable/Disable plugin
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{plugin}/enable",
     *      name = "admin_plugin_enable",
     *      methods = {"POST"}
     * )
     *
     * @JsonResponse()
     */
    public function enablePluginAction(Request $request, $plugin)
    {
        $enabled = (boolean) $request
            ->request
            ->get('value');

        $this
            ->get('elcodi.plugin_manager')
            ->updatePlugin($plugin, $enabled);

        return [
            'status' => 200,
            'response' => [
                'Plugin status saved',
            ],
        ];
    }
}
