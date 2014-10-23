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

namespace Elcodi\StoreCartBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as AnnotationEntity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Elcodi\Component\Cart\Entity\Order;
use Elcodi\Component\Currency\Entity\Money;

/**
 * Class CheckoutController
 *
 * @Route(
 *      path = "/checkout",
 * )
 */
class CheckoutController extends Controller
{
    /**
     * Checkout payment step
     *
     * @return array
     *
     * @Route(
     *      path = "/payment",
     *      name = "store_checkout_payment"
     * )
     * @Method("GET")
     * @Template
     */
    public function paymentAction()
    {
        $shippingPrice = Money::create(
            455,
            $this
                ->get('elcodi.repository.currency')
                ->findOneBy([
                    'iso'   =>  'USD',
                ])
        );

        return [
            'cart' => $this
                    ->get('elcodi.cart_wrapper')
                    ->loadCart(),
            'shippingPrice' => $shippingPrice
        ];
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
     *      name = "store_checkout_payment_fail"
     * )
     * @Method("GET")
     *
     * @Template
     *
     * @AnnotationEntity(
     *      class = "elcodi.core.cart.entity.order.class",
     *      name = "order",
     *      mapping = {
     *          "id" = "~id~",
     *      }
     * )
     */
    public function paymentFailAction(Order $order)
    {
        /*
         * Checking if logged user has permission to see
         * this page
         */
        if ($order->getCustomer() != $this->get('elcodi.customer_wrapper')->loadCustomer()) {
            throw($this->createNotFoundException());
        }

        return [
            'order' => $order
        ];
    }
}
