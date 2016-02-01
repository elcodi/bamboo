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

namespace Elcodi\Store\CartBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Shipping\Entity\ShippingMethod;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Elcodi\Store\CoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Class CheckoutController
 *
 * @Security("has_role('ROLE_CUSTOMER')")
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
                ->get('elcodi.wrapper.customer')
                ->get()
                ->addAddress($address);

            $this->get('elcodi.object_manager.customer')
                ->flush();

            $translator = $this->get('translator');
            $this->addFlash(
                'success', $translator
                ->trans('store.address.save.response_ok')
            );

            return $this->redirect(
                $this->generateUrl('store_checkout_address')
            );
        }

        $addressFormatter = $this->get('elcodi.formatter.address');

        $cart = $this
            ->get('elcodi.wrapper.cart')
            ->get();

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
            'Pages:checkout-address.html.twig',
            [
                'cart'      => $cart,
                'addresses' => $addressesFormatted,
                'form'      => $formView,
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
    public function saveAddressAction(Request $request)
    {
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
                        ->get('elcodi.wrapper.cart')
                        ->get();

                    $cart->$setMethodName($address);

                    $cartObjectManager = $this
                        ->get('elcodi.object_manager.cart');
                    $cartObjectManager->persist($cart);
                    $cartObjectManager->flush();
                }
            } else {
                $translator = $this->get('translator');
                $type = $translator->trans($addressType);
                $this->addFlash(
                    'success',
                    $translator->trans(
                        'store.address.select_address_type',
                        ['%1' => $type]
                    )
                );
            }
        };

        $saveCheckoutAddress(
            $deliveryAddressId,
            'store.address.delivery',
            'setDeliveryAddress'
        );

        $saveCheckoutAddress(
            $billingAddressId,
            'store.address.billing',
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
     * @param CartInterface $cart Cart
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/payment",
     *      name = "store_checkout_payment",
     *      methods = {"GET"}
     * )
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.wrapper.cart",
     *          "method" = "get",
     *          "static" = false
     *      },
     *      name = "cart"
     * )
     */
    public function paymentAction(CartInterface $cart)
    {
        /**
         * If some address is missing in loaded cart, then we should go back to
         * address screen
         */
        if (
            !($cart->getDeliveryAddress() instanceof AddressInterface) ||
            !($cart->getBillingAddress() instanceof AddressInterface)
        ) {
            return $this->redirect($this->generateUrl('store_checkout_address'));
        }

        /**
         * Available payment methods
         */
        $paymentMethods = $this
            ->get('elcodi.wrapper.payment_methods')
            ->get($cart);

        /**
         * Available shipping methods
         */
        $shippingMethods = $this
            ->get('elcodi.wrapper.shipping_methods')
            ->get($cart);

        /**
         * By default, if the cart has not shipping data and we have available
         * some of them, we assign the first one.
         * Then we reload page to recalculate cart values
         */
        if (
            $cart->getShippingMethod() == null &&
            !empty($shippingMethods)
        ) {
            $shippingMethodApplied = reset($shippingMethods);
            $cart->setShippingMethod($shippingMethodApplied->getId());
            $this
                ->get('elcodi.object_manager.cart')
                ->flush($cart);

            return $this->redirect(
                $this->generateUrl('store_checkout_payment')
            );
        }

        $cartCoupons = $this
            ->get('elcodi.manager.cart_coupon')
            ->getCartCoupons($cart);

        return $this->renderTemplate(
            'Pages:checkout-payment.html.twig',
            [
                'shippingMethods' => $shippingMethods,
                'paymentMethods'  => $paymentMethods,
                'cart'            => $cart,
                'cartCoupons'     => $cartCoupons,
            ]
        );
    }

    /**
     * Checkout shipping range
     *
     * @param CartInterface $cart           Cart
     * @param string        $shippingMethod Shipping method
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/shipping/method/change/{shippingMethod}",
     *      name = "store_checkout_shipping_method_apply",
     *      methods = {"GET"}
     * )
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.wrapper.cart",
     *          "method" = "get",
     *          "static" = false
     *      },
     *      name = "cart"
     * )
     */
    public function applyShippingMethodAction(
        CartInterface $cart,
        $shippingMethod
    ) {
        /**
         * Desired shipping method
         */
        $shippingMethodObject = $this
            ->get('elcodi.wrapper.shipping_methods')
            ->getOneById($cart, $shippingMethod);

        if ($shippingMethodObject instanceof ShippingMethod) {
            $cart->setShippingMethod($shippingMethod);
            $this
                ->get('elcodi.object_manager.cart')
                ->flush($cart);
        }

        return $this->redirect(
            $this->generateUrl('store_checkout_payment')
        );
    }

    /**
     * Checkout payment fail action
     *
     * @param CustomerInterface $customer Customer
     * @param OrderInterface    $order    Order
     *
     * @throws AccessDeniedException Customer cannot see this Order
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
     *          "method" = "get",
     *          "static" = false
     *      },
     *      name = "customer",
     * )
     * @EntityAnnotation(
     *      class = "elcodi.entity.order.class",
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
            throw($this->createAccessDeniedException());
        }

        return $this->renderTemplate(
            'Pages:checkout-payment-fail.html.twig',
            [
                'order' => $order,
            ]
        );
    }
}
