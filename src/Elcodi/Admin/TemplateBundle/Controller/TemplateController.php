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

namespace Elcodi\Admin\TemplateBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;

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
        $configurationManager = $this->get('elcodi.configuration_manager');

        $templates = $configurationManager->get('store.templates');
        $currentTemplate = $configurationManager->get('store.template');

        foreach ($templates as $position => $template) {
            $assetPath = str_replace('bundle', '', strtolower($template['bundle']));
            $templates[$position]['assetPath'] = $assetPath;
        }

        return [
            'templates'       => $templates,
            'currentTemplate' => $currentTemplate,
        ];
    }
}
