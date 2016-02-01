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

namespace Elcodi\Admin\TemplateBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\PluginTypes;
use Elcodi\Component\Store\Entity\Interfaces\StoreInterface;

/**
 * Class Controller for Templates
 *
 * @Route(
 *      path = "/template",
 * )
 */
class TemplateController extends AbstractAdminController
{
    /**
     * List templates
     *
     * @return array Result
     *
     * @Route(
     *      path = "s",
     *      name = "admin_template_list",
     *      methods = {"GET"}
     * )
     * @Template
     */
    public function listAction()
    {
        /**
         * @var Plugin[] $templates
         */
        $templates = $this
            ->get('elcodi.repository.plugin')
            ->findBy([
                'type' => PluginTypes::TYPE_TEMPLATE,
            ]);

        $assetPaths = [];

        foreach ($templates as $plugin) {
            $assetPath = str_replace('bundle', '', strtolower($plugin->getBundleName()));
            $assetPaths[$plugin->getHash()] = $assetPath;
        }

        return [
            'templates'       => $templates,
            'assetPaths'      => $assetPaths,
        ];
    }

    /**
     * Assign a template selection to the store
     *
     * @param StoreInterface $store Store
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/assign/{hash}",
     *      name = "admin_template_assign",
     *      methods = {"POST"}
     * )
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.wrapper.store",
     *          "method" = "get",
     *          "static" = false
     *      },
     *      name = "store"
     * )
     * @JsonResponse()
     */
    public function assignAction(
        StoreInterface $store,
        $hash
    ) {
        /**
         * @var Plugin $plugin
         */
        $plugin = $this
            ->get('elcodi.repository.plugin')
            ->findOneBy([
                'hash' => $hash,
                'type' => PluginTypes::TYPE_TEMPLATE,
            ]);

        $store->setTemplate($plugin->getHash());

        $this
            ->get('elcodi.object_manager.store')
            ->flush($store);

        return [
            'status'  => 200,
            'message' => 'ok',
        ];
    }
}
