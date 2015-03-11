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

namespace Elcodi\Admin\GeoBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;

/**
 * Class Controller for Address
 *
 * @Route(
 *      path = "/address",
 * )
 */
class AddressController extends AbstractAdminController
{
    /**
     * Edits an address
     *
     * @return array Result
     *
     * @Route(
     *      path = "",
     *      name = "admin_address_edit"
     * )
     * @Template
     * @Method({"GET","POST"})
     */
    public function editAction(Request $request)
    {
        $storeAddressManager = $this
            ->get('elcodi.service.store_address_manager');

        $address = $storeAddressManager
            ->getStoreAddress();

        if (!$address instanceof AddressInterface) {
            return $this->redirectRoute("admin_address_new");
        }

        $form = $this->createForm(
            'admin_geo_form_type_address',
            $address
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $addressManager = $this
                ->get('elcodi.manager.address');

            $addressManager
                ->saveAddress($address);

            $savedAddress = $addressManager
                ->getSavedAddress();

            $this
                ->get('elcodi.service.store_address_manager')
                ->setStoreAddress($savedAddress);

            $this->addFlash('success', 'admin.address.saved');

            return $this->redirectRoute("admin_address_edit");
        }

        return $this->render(
            'AdminGeoBundle:Address:edit.html.twig',
            [
                'form'    => $form->createView(),
                'address' => $address,
            ]
        );
    }

    /**
     * Adds a new address
     *
     * @param Form             $form    The address form
     * @param AddressInterface $address An address
     *
     * @return Response
     *
     * @Route(
     *      path = "/new",
     *      name = "admin_address_new"
     * )
     * @Method({"GET","POST"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.address",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      name = "address",
     *      persist = false
     * )
     * @FormAnnotation(
     *      class         = "admin_geo_form_type_address",
     *      name          = "form",
     *      entity        = "address",
     *      handleRequest = true,
     *      validate      = "isValid"
     * )
     */
    public function newAction(
        Form $form,
        AddressInterface $address
    ) {
        if ($form->isValid()) {
            $addressManager = $this->get('elcodi.object_manager.address');
            $addressManager->persist($address);
            $addressManager->flush($address);

            $this
                ->get('elcodi.service.store_address_manager')
                ->setStoreAddress($address);

            $this->addFlash('success', 'admin.address.saved');

            return $this->redirectRoute("admin_address_edit");
        }

        return $this->render(
            'AdminGeoBundle:Address:edit.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
