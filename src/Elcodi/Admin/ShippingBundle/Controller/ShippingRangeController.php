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

namespace Elcodi\Admin\ShippingBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Shipping\Entity\Interfaces\CarrierInterface;
use Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface;

/**
 * Class ShippingRangeController
 *
 * @Route(
 *      path = "carrier/{carrierId}/range"
 * )
 */
class ShippingRangeController extends AbstractAdminController
{
    /**
     * Edit and Saves category
     *
     * @param FormInterface          $form          Form
     * @param CarrierInterface       $carrier       Carrier
     * @param ShippingRangeInterface $shippingRange Shipping range
     * @param boolean                $isValid       Is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}",
     *      name = "admin_shipping_range_edit",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/{id}/update",
     *      name = "admin_shipping_range_update",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"POST"}
     * )
     *
     * @Route(
     *      path = "/new",
     *      name = "admin_shipping_range_new",
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/new/update",
     *      name = "admin_shipping_range_save",
     *      methods = {"POST"}
     * )
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
     *          "factory" = "elcodi.factory.shipping_range",
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
     *      class = "elcodi_admin_shipping_form_type_shipping_range",
     *      name  = "form",
     *      entity = "shippingRange",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     *
     * @Template
     */
    public function editAction(
        FormInterface $form,
        CarrierInterface $carrier,
        ShippingRangeInterface $shippingRange,
        $isValid
    ) {
        if ($isValid) {

            /**
             * We must add the default Carrier
             */
            $shippingRange->setCarrier($carrier);

            $this->flush($shippingRange);

            $this->addFlash(
                'success',
                'Changes saved'
            );

            return $this->redirectToRoute('admin_carrier_list');
        }

        return [
            'shippingRange' => $shippingRange,
            'carrier'       => $carrier,
            'form'          => $form->createView(),
        ];
    }
}
