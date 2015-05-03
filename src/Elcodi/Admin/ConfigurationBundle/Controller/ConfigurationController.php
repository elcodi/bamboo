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
        return [
            'languages'  => $languages,
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
     * @FormAnnotation(
     *      class = "elcodi_admin_product_form_type_product",
     *      name  = "formView",
     *      entity = "product",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     *
     * @JsonResponse()
     */
    public function updateAction(Request $request, $name)
    {
        $value = $request
            ->request
            ->get('value');

        $storeManager = $this->get('elcodi.object_manager.store');
        $store = $this
            ->get('elcodi.store')
            ->$name($value);

        $storeManager->flush($store);

        return [
            'status'   => 200,
            'response' => [
                $this->translate('admin.settings.saved'),
            ],
        ];
    }
}
