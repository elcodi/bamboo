<?php

/**
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
 */

namespace Elcodi\Store\StoreCartBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Entity\Order;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Elcodi\Store\StoreCoreBundle\Controller\Traits\TemplateRenderTrait;

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
            ->get('elcodi.cart_wrapper')
            ->loadCart();

        return $this->renderTemplate(
            'Pages:cart-checkout.html.twig',
            [
                'shippingPrice' => $shippingPrice,
                'cart'          => $cart
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
     *          "factory" = "elcodi.customer_wrapper",
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
    )
    {
        /**
         * Checking if logged user has permission to see
         * this page
         */
        if ($order->getCustomer() != $customer) {

            throw($this->createNotFoundException());
        }

        return $this->renderTemplate(
            'Pages:cart-checkout-fail.html.twig',
            [
                'order' => $order
            ]
        );
    }
}
