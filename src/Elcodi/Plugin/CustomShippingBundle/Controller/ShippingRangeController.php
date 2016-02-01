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

namespace Elcodi\Plugin\CustomShippingBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Plugin\CustomShippingBundle\Entity\Interfaces\CarrierInterface;
use Elcodi\Plugin\CustomShippingBundle\Entity\Interfaces\ShippingRangeInterface;

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
                $this
                    ->get('translator')
                    ->trans('admin.shipping_range.saved')
            );

            return $this->redirectToRoute('admin_carrier_edit', [
                'id' => $carrier->getId(),
            ]);
        }

        return [
            'shippingRange' => $shippingRange,
            'carrier'       => $carrier,
            'form'          => $form->createView(),
        ];
    }

    /**
     * Delete entity
     *
     * @param Request $request      Request
     * @param mixed   $entity       Entity to delete
     * @param string  $redirectPath Redirect path
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}/delete",
     *      name = "admin_shipping_range_delete",
     *      methods = {"GET", "POST"}
     * )
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.shipping_range.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function deleteAction(
        Request $request,
        $entity,
        $redirectPath = null
    ) {
        /**
         * @var ShippingRangeInterface $entity
         */
        $carrierId = $entity
            ->getCarrier()
            ->getId();

        parent::deleteAction(
            $request,
            $entity,
            $this->generateUrl('admin_carrier_edit', [
                'id' => $carrierId,
            ])
        );
    }
}
