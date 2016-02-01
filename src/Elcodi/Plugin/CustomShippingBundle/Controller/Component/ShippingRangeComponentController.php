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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormView;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Plugin\CustomShippingBundle\Entity\Interfaces\CarrierInterface;
use Elcodi\Plugin\CustomShippingBundle\Entity\Interfaces\ShippingRangeInterface;

/**
 * Class ShippingRangeComponentController
 *
 * @Route(
 *      path = "carrier/{carrierId}/range"
 * )
 */
class ShippingRangeComponentController extends AbstractAdminController
{
    /**
     * Component for entity list.
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param CarrierInterface $carrier Carrier
     *
     * @return array Result
     *
     * @Route(
     *      path = "s",
     *      name = "admin_shipping_range_list_component",
     * )
     * @Template("ElcodiCustomShippingBundle:ShippingRange:listComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.carrier.class",
     *      mapping = {
     *          "id" = "~carrierId~"
     *      },
     *      name = "carrier"
     * )
     */
    public function listComponentAction(CarrierInterface $carrier)
    {
        $shippingRanges = $this
            ->get('elcodi.repository.shipping_range')
            ->findBy([
                'carrier' => $carrier,
            ]);

        return [
            'paginator' => $shippingRanges,
            'carrier'   => $carrier,
        ];
    }

    /**
     * New element component action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param FormView               $formView      Form view
     * @param CarrierInterface       $carrier       Carrier
     * @param ShippingRangeInterface $shippingRange Shipping range
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/component",
     *      name = "admin_shipping_range_edit_component",
     *      requirements = {
     *          "id" = "\d+",
     *      }
     * )
     * @Route(
     *      path = "/new/component",
     *      name = "admin_shipping_range_new_component",
     *      methods = {"GET"}
     * )
     * @Template("ElcodiCustomShippingBundle:ShippingRange:editComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.carrier.class",
     *      mapping = {
     *          "id" = "~carrierId~"
     *      },
     *      name = "carrier"
     * )
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi_plugin.custom_shipping.factory.shipping_range",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      name = "shippingRange",
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_plugin_custom_shipping_form_type_shipping_range",
     *      name  = "formView",
     *      entity = "shippingRange",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function editComponentAction(
        FormView $formView,
        CarrierInterface $carrier,
        ShippingRangeInterface $shippingRange
    ) {
        return [
            'shippingRange' => $shippingRange,
            'carrier'       => $carrier,
            'form'          => $formView,
        ];
    }
}
