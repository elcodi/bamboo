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

namespace Elcodi\Admin\TemplateBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\PluginTypes;

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
        $currentTemplate = $this
            ->get('elcodi.store')
            ->getTemplate();

        foreach ($templates as $plugin) {
            $assetPath = str_replace('bundle', '', strtolower($plugin->getBundleName()));
            $assetPaths[$plugin->getHash()] = $assetPath;
        }

        return [
            'templates'       => $templates,
            'currentTemplate' => $currentTemplate,
            'assetPaths'      => $assetPaths,
        ];
    }
}
