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

namespace Elcodi\Store\CartBundle\Controller;

use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Entity\Order;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Elcodi\Store\CoreBundle\Controller\Traits\TemplateRenderTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CheckoutController
 *
 * @Route(
 *      path = "/checkout",
 * )
 */
class CheckoutController extends Controller
{
    use TemplateRenderTrait;

    /**
     * Checkout address step
     *
     * @param AddressInterface $address  The address being added
     * @param FormView         $formView The form
     * @param boolean          $isValid  If the processed form si valid
     *
     * @return Response
     *
     * @Route(
     *      path = "/address",
     *      name = "store_checkout_address",
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
    public function addressAction(
        AddressInterface $address,
        FormView $formView,
        $isValid
    ) {
        if ($isValid) {

            // User is adding a new address
            $addressManager = $this->get('elcodi.object_manager.address');
            $addressManager->persist($address);
            $addressManager->flush();

            $this
                ->get('elcodi.customer_wrapper')
                ->loadCustomer()
                ->addAddress($address);

            $this->get('elcodi.object_manager.customer')
                ->flush();

            $this->addFlash('success', 'Address saved');

            return $this->redirect(
                $this->generateUrl('store_checkout_address')
            );
        }

        $locationProvider = $this->get('elcodi.location_provider');

        $cart = $this
            ->get('elcodi.cart_wrapper')
            ->loadCart();

        $addresses = $this
            ->get('elcodi.customer_wrapper')
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
            'Pages:checkout-address.html.twig',
            [
                'cart'        => $cart,
                'addresses'   => $addresses,
                'cities_info' => $cities_info,
                'form'        => $formView,
            ]
        );
    }

    /**
     * Saves the billing and delivery address and redirects to the next page
     *
     * @param Request $request The current request
     *
     * @return Response
     *
     * @Route(
     *      path = "/address/save",
     *      name = "store_checkout_address_save",
     *      methods = {"POST"}
     * )
     */
    public function saveAddressAction(
        Request $request
    ) {
        $billingAddressId = $request
            ->request
            ->get('billing', false);

        $deliveryAddressId = $request
            ->request
            ->get('delivery', false);

        $saveCheckoutAddress = function (
            $addressId,
            $addressType,
            $setMethodName
        ) {
            if ($addressId) {

                $address = $this
                    ->get('elcodi.repository.address')
                    ->findOneBy(['id' => $addressId]);

                $customerAddresses = $this
                    ->getUser()
                    ->getAddresses();

                if ($customerAddresses->contains($address)) {
                    $cart = $this
                        ->get('elcodi.cart_wrapper')
                        ->loadCart();

                    $cart->$setMethodName($address);

                    $cartObjectManager = $this
                        ->get('elcodi.object_manager.cart');
                    $cartObjectManager->persist($cart);
                    $cartObjectManager->flush();
                }

            } else {
                $this->addFlash(
                    'success',
                    "Select a $addressType address"
                );
            }
        };

        $saveCheckoutAddress(
            $deliveryAddressId,
            'delivery',
            'setDeliveryAddress'
        );

        $saveCheckoutAddress(
            $billingAddressId,
            'billing',
            'setBillingAddress'
        );

        $redirectionUrl = ($billingAddressId && $deliveryAddressId)
            ? 'store_checkout_payment'
            : 'store_checkout_address';

        return $this->redirect(
            $this->generateUrl($redirectionUrl)
        );
    }

    /**
     * Checkout payment step
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/payment",
     *      name = "store_checkout_payment",
     *      methods = {"GET"}
     * )
     */
    public function paymentAction()
    {
        $dollar = $this
            ->get('elcodi.repository.currency')
            ->findOneBy([
                'iso' => 'USD',
            ]);

        $shippingPrice = Money::create(
            455,
            $dollar
        );

        $cart = $this
            ->get('elcodi.wrapper.cart')
            ->loadCart();

        return $this->renderTemplate(
            'Pages:checkout-payment.html.twig',
            [
                'shippingPrice' => $shippingPrice,
                'cart'          => $cart,
            ]
        );
    }

    /**
     * Checkout payment fail action
     *
     * @param Order $order Order
     *
     * @throws NotFoundHttpException
     *
     * @return array
     *
     * @Route(
     *      path = "/payment/fail/order/{id}",
     *      name = "store_checkout_payment_fail",
     *      methods = {"GET"}
     * )
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.wrapper.customer",
     *          "method" = "loadCustomer",
     *          "static" = false
     *      },
     *      name = "customer",
     * )
     * @EntityAnnotation(
     *      class = "elcodi.core.cart.entity.order.class",
     *      name = "order",
     *      mapping = {
     *          "id" = "~id~",
     *      }
     * )
     */
    public function paymentFailAction(
        CustomerInterface $customer,
        OrderInterface $order
    ) {
        /**
         * Checking if logged user has permission to see
         * this page
         */
        if ($order->getCustomer() != $customer) {
            throw($this->createNotFoundException());
        }

        return $this->renderTemplate(
            'Pages:checkout-payment-fail.html.twig',
            [
                'order' => $order,
            ]
        );
    }
}
