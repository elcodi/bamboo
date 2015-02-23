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

namespace Elcodi\Admin\ShippingBundle\Controller\Component;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormView;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Shipping\Entity\Interfaces\CarrierInterface;

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
     * )
     * @Template("AdminShippingBundle:Carrier:listComponent.html.twig")
     * @Method({"GET"})
     */
    public function listComponentAction()
    {
        $carriers = $this
            ->get('elcodi.repository.carrier')
            ->findAll();

        return [
            'carriers' => $carriers,
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
     *      requirements = {
     *          "id" = "\d+",
     *      }
     * )
     * @Route(
     *      path = "/new/component",
     *      name = "admin_carrier_new_component",
     *      methods = {"GET"}
     * )
     * @Template("AdminShippingBundle:Carrier:editComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.carrier",
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
     *      class = "elcodi_admin_shipping_form_type_carrier",
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
