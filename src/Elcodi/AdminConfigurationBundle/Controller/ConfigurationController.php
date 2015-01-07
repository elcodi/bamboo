<?php

/**
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

namespace Elcodi\AdminConfigurationBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\AdminCoreBundle\Controller\Abstracts\AbstractAdminController;

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
     *      name = "admin_configuration_list"
     * )
     * @Template
     * @Method({"GET"})
     */
    public function listAction()
    {
        $currencies = $this
            ->get('elcodi.repository.currency')
            ->findBy([
                'enabled' => true
            ]);

        $languages = $this
            ->get('elcodi.repository.language')
            ->findBy([
                'enabled' => true
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
     *      path = "/{id}/update",
     *      name = "admin_configuration_update"
     * )
     * @Method({"POST"})
     *
     * @JsonResponse()
     */
    public function updateAction(Request $request, $id)
    {
        $value = $request
            ->request
            ->get('value');

        $this
            ->get('elcodi.configuration_manager')
            ->setParameter($id, $value);

        return [
            'status' => 200,
            'response' => [
                'Configuration saved',
            ]
        ];
    }
}
