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

namespace Elcodi\Admin\ConfigurationBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;

/**
 * Class Controller for Category
 *
 * @Route(
 *      path = "/configuration",
 * )
 */
class ConfigurationController extends AbstractAdminController
{
    /**
     * List configuration values
     *
     * @return array Result
     *
     * @Route(
     *      path = "",
     *      name = "admin_configuration_list",
     *      methods = {"GET"},
     * )
     *
     * @Template
     */
    public function listAction()
    {
        $currencies = $this
            ->get('elcodi.repository.currency')
            ->findBy([
                'enabled' => true,
            ]);

        $languages = $this
            ->get('elcodi.repository.language')
            ->findBy([
                'enabled' => true,
            ]);

        return [
            'languages' => $languages,
            'currencies' => $currencies,
        ];
    }

    /**
     * List configuration values
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{name}/update",
     *      name = "admin_configuration_update",
     *      requirements = {
     *          "name" = ".+"
     *      },
     *      methods = {"POST"},
     * )
     *
     * @JsonResponse()
     */
    public function updateAction(Request $request, $name)
    {
        $value = $request
            ->request
            ->get('value');

        $this
            ->get('elcodi.manager.configuration')
            ->set($name, $value);

        $translator = $this->get('translator');

        return [
            'status' => 200,
            'response' => [
                $translator->trans('admin.settings.saved'),
            ],
        ];
    }
}
