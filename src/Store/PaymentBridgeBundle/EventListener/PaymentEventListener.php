<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  * @version  */

namespace Store\PaymentBridgeBundle\EventListener;

use PaymentSuite\PaymentCoreBundle\Event\PaymentOrderLoadEvent;

use Elcodi\CartBundle\Services\OrderManager;
use Elcodi\CartBundle\Wrapper\CartWrapper;

/**
 * Class PaymentEventListener
 */
class PaymentEventListener
{
    /**
     * @var CartWrapper
     *
     * cartWrapper
     */
    protected $cartWrapper;

    /**
     * @var OrderManager
     *
     * OrderManager
     */
    protected $orderManager;

    public function __construct(
        CartWrapper $cartWrapper,
        OrderManager $orderManager
    )
    {
        $this->cartWrapper = $cartWrapper;
        $this->orderManager = $orderManager;
    }

    /**
     * Create order given current cart
     *
     * @param PaymentOrderLoadEvent $event Event
     */
    public function onPaymentOrderLoad(PaymentOrderLoadEvent $event)
    {
        $cart = $this
            ->cartWrapper
            ->loadCart();

        $order = $this
            ->orderManager
            ->createOrderFromCart($cart);

        $event
            ->getPaymentBridge()
            ->setOrder($order);
    }
}
