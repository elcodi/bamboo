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

namespace Store\PaymentBridgeBundle\EventListener;

use Elcodi\CartBundle\Transformer\CartOrderTransformer;
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
    protected $cartOrderTransformer;

    /**
     * Construct method
     *
     * @param CartWrapper          $cartWrapper          Cart Wrapper
     * @param CartOrderTransformer $cartOrderTransformer Cart Order Transformer
     */
    public function __construct(
        CartWrapper $cartWrapper,
        CartOrderTransformer $cartOrderTransformer
    )
    {
        $this->cartWrapper = $cartWrapper;
        $this->cartOrderTransformer = $cartOrderTransformer;
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
            ->cartOrderTransformer
            ->createOrderFromCart($cart);

        $event
            ->getPaymentBridge()
            ->setOrder($order);
    }
}
