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

namespace Elcodi\Store\GeoBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Elcodi\Store\CoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Address controllers
 *
 * @Route(
 *      path = "/user/address",
 * )
 */
class AddressController extends Controller
{
    use TemplateRenderTrait;

    /**
     * List addresses page
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/",
     *      name = "store_address_list",
     *      methods = {"GET"}
     * )
     */
    public function listAction()
    {
        $locationProvider = $this->get('elcodi.location_provider');

        $addresses = $this
            ->get('elcodi.wrapper.customer')
            ->loadCustomer()
            ->getAddresses();

        $cities_info = [];
        foreach ($addresses as $address) {
            $cities_info[$address->getCity()] =
                $locationProvider->getHierarchy(
                    $address->getCity()
                );
        }

        return $this->renderTemplate(
            'Pages:address-list.html.twig',
            [
                'addresses'   => $addresses,
                'cities_info' => $cities_info,
            ]
        );
    }

    /**
     * Edit an address
     *
     * @param integer $id      The address id
     * @param Request $request The current request
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/edit/{id}",
     *      name = "store_address_edit",
     *      methods = {"GET","POST"}
     * )
     */
    public function editAction(
        $id,
        Request $request
    ) {
        $address = $this->get('elcodi.repository.customer')
            ->findAddress(
                $this->getUser()->getId(),
                $id
            );

        if (false === $address) {
            throw new NotFoundHttpException('Address not found');
        }

        $form = $this->createForm('store_geo_form_type_address', $address);
        $form->handleRequest($request);

        $entityManager = $this->get('elcodi.object_manager.address');
        if ($form->isValid()) {
            $entityManager->flush($address);

            $this->addFlash('success', 'Address saved');

            return $this->redirect(
                $this->generateUrl('store_address_list')
            );
        } else {
            $entityManager->clear($address);
        }

        return $this->renderTemplate(
            'Pages:address-edit.html.twig',
            [
                'address' => $address,
                'form'    => $form->createView(),
            ]
        );
    }

    /**
     * New address
     *
     * @param AddressInterface $address  $address A new address entity
     * @param FormView         $formView The form view
     * @param boolean          $isValid  If the form is valid
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/new",
     *      name = "store_address_new",
     *      methods = {"GET","POST"}
     * )
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
     *      class         = "store_geo_form_type_address",
     *      name          = "formView",
     *      entity        = "address",
     *      handleRequest = true,
     *      validate      = "isValid"
     * )
     */
    public function newAction(
        AddressInterface $address,
        FormView $formView,
        $isValid
    ) {
        if ($isValid) {
            $addressManager = $this->get('elcodi.object_manager.address');
            $addressManager->persist($address);
            $addressManager->flush();

            $this
                ->get('elcodi.wrapper.customer')
                ->loadCustomer()
                ->addAddress($address);

            $this->get('elcodi.object_manager.customer')
                ->flush();

            $this->addFlash('success', 'Address saved');

            return $this->redirect(
                $this->generateUrl('store_address_list')
            );
        }

        return $this->renderTemplate(
            'Pages:address-edit.html.twig',
            [
                'address' => $address,
                'form'    => $formView,
            ]
        );
    }

    /**
     * Delete address
     *
     * @param integer $id The address id
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/delete/{id}",
     *      name = "store_address_delete",
     *      methods = {"GET"}
     * )
     */
    public function deleteAction(
        $id
    ) {
        /**
         * @var CustomerInterface $customer
         */
        $customer = $this->getUser();
        $address  = $this->get('elcodi.repository.customer')
            ->findAddress(
                $customer->getId(),
                $id
            );

        if (false === $address) {
            throw new NotFoundHttpException('Address not found');
        }

        $customer->removeAddress($address);
        $addressManager = $this->get('elcodi.object_manager.address');
        $addressManager->remove($address);
        $addressManager->flush();

        $this->addFlash('success', 'Address removed');

        return $this->redirect(
            $this->generateUrl('store_address_list')
        );
    }
}
