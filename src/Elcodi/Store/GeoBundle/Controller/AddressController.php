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

namespace Elcodi\Store\GeoBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
 * @Security("has_role('ROLE_CUSTOMER')")
 * @Route(
 *      path = "/user/address",
 * )
 */
class AddressController extends Controller
{
    use TemplateRenderTrait;

    /**
     * @var string
     *
     * Checkout source, used for redirection.
     */
    const CHECKOUT_SOURCE = 'checkout';

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
        $addressFormatter = $this->get('elcodi.formatter.address');

        $addresses = $this
            ->get('elcodi.wrapper.customer')
            ->get()
            ->getAddresses();

        $addressesFormatted = [];
        foreach ($addresses as $address) {
            $addressesFormatted[] =
                $addressFormatter
                    ->toArray($address);
        }

        return $this->renderTemplate(
            'Pages:address-list.html.twig',
            [
                'addresses' => $addressesFormatted,
            ]
        );
    }

    /**
     * Edit an address
     *
     * @param integer $id      The address id
     * @param Request $request The current request
     * @param string  $source  The form source to redirect back
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/{id}/edit/{source}",
     *      name = "store_address_edit",
     *      methods = {"GET","POST"},
     *      defaults = {
     *          "source" = null,
     *      },
     * )
     */
    public function editAction(
        $id,
        Request $request,
        $source
    ) {
        $address = $this
            ->get('elcodi.repository.customer')
            ->findAddress(
                $this->getUser()->getId(),
                $id
            );

        if (!($address instanceof AddressInterface)) {
            throw new NotFoundHttpException('Address not found');
        }

        $form = $this
            ->createForm(
                'store_geo_form_type_address',
                $address
            );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $addressToSave = $this
                ->get('elcodi.manager.address')
                ->saveAddress($address);

            $customer = $this->getUser();
            $customer->removeAddress($address);
            $customer->addAddress($addressToSave);
            $this
                ->get('elcodi.object_manager.customer')
                ->flush($customer);

            $message = $this
                ->get('translator')
                ->trans('store.address.save.response_ok');

            $this->addFlash('success', $message);

            $redirectUrl = self::CHECKOUT_SOURCE == $source
                ? 'store_checkout_address'
                : 'store_address_list';

            return $this->redirect(
                $this->generateUrl($redirectUrl)
            );
        } else {
            $this
                ->get('elcodi.object_manager.address')
                ->clear($address);
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
     * @param string|null      $source   The form source to redirect back
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/new/{source}",
     *      name = "store_address_new",
     *      methods = {"GET","POST"},
     *      defaults = {
     *          "source" = null,
     *      },
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
        $isValid,
        $source = null
    ) {
        if ($isValid) {
            $translator = $this->get('translator');

            $addressManager = $this->get('elcodi.object_manager.address');
            $addressManager->persist($address);
            $addressManager->flush();

            $this
                ->get('elcodi.wrapper.customer')
                ->get()
                ->addAddress($address);

            $this
                ->get('elcodi.object_manager.customer')
                ->flush();

            $message = $translator->trans('store.address.save.response_ok');
            $this->addFlash('success', $message);

            $redirectUrl = self::CHECKOUT_SOURCE == $source
                ? 'store_checkout_address'
                : 'store_address_list';

            return $this->redirect(
                $this->generateUrl($redirectUrl)
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
     * @param integer     $id     The address id
     * @param string|null $source The form source to redirect back
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/{id}/delete",
     *      name = "store_address_delete",
     *      methods = {"GET"},
     *      defaults = {
     *          "source" = null,
     *      },
     * )
     */
    public function deleteAction(
        $id,
        $source = null
    ) {
        $translator = $this->get('translator');

        /**
         * @var CustomerInterface $customer
         */
        $customer = $this->getUser();
        $address = $this
            ->get('elcodi.repository.customer')
            ->findAddress(
                $customer->getId(),
                $id
            );

        if (!($address instanceof AddressInterface)) {
            throw new NotFoundHttpException('Address not found');
        }

        $customerManager = $this->get('elcodi.object_manager.customer');
        $customer->removeAddress($address);
        $customerManager->flush($customer);

        $message = $translator->trans('store.address.delete.response_ok');
        $this->addFlash('success', $message);

        $redirectUrl = self::CHECKOUT_SOURCE == $source
            ? 'store_checkout_address'
            : 'store_address_list';

        return $this->redirect(
            $this->generateUrl($redirectUrl)
        );
    }
}
