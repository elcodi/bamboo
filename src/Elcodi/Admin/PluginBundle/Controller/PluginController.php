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

namespace Elcodi\Admin\PluginBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\JsonResponse;
use RuntimeException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\PluginTypes;

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
     * @param string $category Optional plugin category
     *
     * @return array Result
     *
     * @Route(
     *      path = "s",
     *      name = "admin_plugin_list",
     *      methods = {"GET"}
     * )
     *
     * @Route(
     *      path = "s/{category}",
     *      name = "admin_plugin_categorized_list",
     *      methods = {"GET"}
     * )
     *
     * @Template
     */
    public function listAction($category = null)
    {
        $criteria = [
            'type' => PluginTypes::TYPE_PLUGIN,
        ];

        if ($category !== null) {
            $criteria['category'] = $category;
        }

        $plugins = $this
            ->get('elcodi.repository.plugin')
            ->findBy(
                $criteria,
                [ 'category' => 'ASC' ]
            );

        return [
            'plugins' => $plugins,
            'category' => $category,
        ];
    }

    /**
     * Configure plugin
     *
     * @param Request $request    Request
     * @param string  $pluginHash Plugin hash
     *
     * @return array Result
     *
     * @throws RuntimeException Plugin not available for configuration
     *
     * @Route(
     *      path = "/{pluginHash}",
     *      name = "admin_plugin_configure",
     *      methods = {"GET", "POST"}
     * )
     * @Template
     */
    public function configureAction(
        Request $request,
        $pluginHash
    ) {
        /**
         * @var Plugin $plugin
         */
        $plugin = $this
            ->get('elcodi.repository.plugin')
            ->findOneBy([
                'hash' => $pluginHash,
            ]);

        $form = $this
            ->createForm(
                'elcodi_form_type_plugin',
                $plugin->getFieldValues(), [
                    'plugin' => $plugin,
                ]
            );

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            $pluginValues = $form->getData();
            $plugin->setFieldValues($pluginValues);
            $this
                ->get('elcodi.object_manager.plugin')
                ->flush($plugin);

            $this->addFlash(
                'success',
                $this
                    ->get('translator')
                    ->trans('admin.plugin.saved')
            );

            return $this
                ->redirectToRoute('admin_plugin_configure', [
                    'pluginHash' => $plugin->getHash(),
                ]);
        }

        return [
            'form' => $form->createView(),
            'plugin' => $plugin,
        ];
    }

    /**
     * Enable/Disable plugin
     *
     * @param Request $request    Request
     * @param string  $pluginHash Plugin hash
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{pluginHash}/enable",
     *      name = "admin_plugin_enable",
     *      methods = {"POST"}
     * )
     * @JsonResponse()
     */
    public function enablePluginAction(
        Request $request,
        $pluginHash
    ) {
        /**
         * @var Plugin $plugin
         */
        $plugin = $this
            ->get('elcodi.repository.plugin')
            ->findOneBy([
                'hash' => $pluginHash,
            ]);

        $enabled = (boolean) $request
            ->request
            ->get('value');

        $plugin->setEnabled($enabled);

        $this
            ->get('elcodi.object_manager.plugin')
            ->flush($plugin);

        $this
            ->get('elcodi.manager.menu')
            ->removeFromCache('admin');

        return [
            'status'   => 200,
            'response' => [
                $this
                    ->get('translator')
                    ->trans('admin.plugin.saved'),
            ],
        ];
    }

    /**
     * Check if, given a plugin hash, a configuration page is available
     *
     * @param Plugin $plugin Plugin
     *
     * @return boolean Is available
     */
    protected function isPluginConfigurable(Plugin $plugin = null)
    {
        return ($plugin instanceof Plugin) && $plugin->hasFields();
    }
}
