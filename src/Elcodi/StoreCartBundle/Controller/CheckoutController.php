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

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Elcodi\CurrencyBundle\Entity\Money;

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
     * Checkout payment step
     *
     * @param int $orderId Order id
     *
     * @return array
     *
     * @Route(
     *      path = "/order/{orderId}",
     *      name = "store_checkout_thanks"
     * )
     * @Method("GET")
     * @Template
     */
    public function orderAction($orderId)
    {
        return [];
    }
}
