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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Shipping\Entity\Interfaces\CarrierInterface;

/**
 * Class CarrierController
 *
 * @Route(
 *      path = "carrier"
 * )
 */
class CarrierController extends AbstractAdminController
{
    /**
     * List elements of certain entity type.
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsibility
     *
     * @return array Result
     *
     * @Route(
     *      path = "s",
     *      name = "admin_carrier_list"
     * )
     * @Template
     * @Method({"GET"})
     */
    public function listAction()
    {
        $enabledCarriers = $this
            ->get('elcodi.repository.carrier')
            ->findBy([
                'enabled' => true,
            ]);

        return [
            'noEnabledCarriers' => empty($enabledCarriers),
        ];
    }

    /**
     * Edit and Saves category
     *
     * @param FormInterface    $form          Form
     * @param CarrierInterface $shippingRange Shipping range
     * @param boolean          $isValid       Is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}",
     *      name = "admin_carrier_edit",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/{id}/update",
     *      name = "admin_carrier_update",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"POST"}
     * )
     *
     * @Route(
     *      path = "/new",
     *      name = "admin_carrier_new",
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/new/update",
     *      name = "admin_carrier_save",
     *      methods = {"POST"}
     * )
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
     *      name  = "form",
     *      entity = "carrier",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     *
     * @Template
     */
    public function editAction(
        FormInterface $form,
        CarrierInterface $carrier,
        $isValid
    ) {
        if ($isValid) {
            $this->flush($carrier);

            $this->addFlash(
                'success',
                'Changes saved'
            );

            return $this->redirectToRoute('admin_carrier_edit', [
                'id' => $carrier->getId(),
            ]);
        }

        return [
            'carrier' => $carrier,
            'form'    => $form->createView(),
        ];
    }
}
