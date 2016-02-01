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

namespace Elcodi\Plugin\CustomShippingBundle\Controller\Component;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormView;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Plugin\CustomShippingBundle\Entity\Interfaces\CarrierInterface;

/**
 * Class CarrierComponentController
 *
 * @Route(
 *      path = "carrier"
 * )
 */
class CarrierComponentController extends AbstractAdminController
{
    /**
     * Component for entity list.
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/component",
     *      name = "admin_carrier_list_component",
     *      methods = {"GET"}
     * )
     * @Template("ElcodiCustomShippingBundle:Carrier:listComponent.html.twig")
     */
    public function listComponentAction()
    {
        $carriers = $this
            ->get('elcodi.repository.carrier')
            ->findAll();

        return [
            'paginator' => $carriers,
        ];
    }

    /**
     * New element component action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param FormView         $formView Form view
     * @param CarrierInterface $carrier  Shipping range
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/component",
     *      name = "admin_carrier_edit_component",
     *      methods = {"GET"},
     *      requirements = {
     *          "id" = "\d+",
     *      }
     * )
     * @Route(
     *      path = "/new/component",
     *      name = "admin_carrier_new_component",
     *      methods = {"GET"}
     * )
     * @Template("ElcodiCustomShippingBundle:Carrier:editComponent.html.twig")
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi_plugin.custom_shipping.factory.carrier",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      name = "carrier",
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_plugin_custom_shipping_form_type_carrier",
     *      name  = "formView",
     *      entity = "carrier",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function editComponentAction(
        FormView $formView,
        CarrierInterface $carrier
    ) {
        return [
            'carrier' => $carrier,
            'form'    => $formView,
        ];
    }
}
