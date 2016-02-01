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

namespace Elcodi\Bridge\PaymentSuiteBridgeBundle\EventListener;

use PaymentSuite\PaymentCoreBundle\Event\Abstracts\AbstractPaymentEvent;

use Elcodi\Component\Cart\Transformer\CartOrderTransformer;
use Elcodi\Component\Cart\Wrapper\CartWrapper;

/**
 * Class CartPaidEventListener
 */
class CartPaidEventListener
{
    /**
     * @var CartWrapper
     *
     * Cart Wrapper
     */
    private $cartWrapper;

    /**
     * @var CartOrderTransformer
     *
     * Cart to Order transformer
     */
    private $cartOrderTransformer;

    /**
     * Construct method
     *
     * @param CartWrapper          $cartWrapper          Cart Wrapper
     * @param CartOrderTransformer $cartOrderTransformer Cart Order Transformer
     */
    public function __construct(
        CartWrapper $cartWrapper,
        CartOrderTransformer $cartOrderTransformer
    ) {
        $this->cartWrapper = $cartWrapper;
        $this->cartOrderTransformer = $cartOrderTransformer;
    }

    /**
     * Create order given current cart. This event is only for pushing the new
     * Order to the payment infrastructure
     *
     * @param AbstractPaymentEvent $event Event
     */
    public function transformCartToOrder(AbstractPaymentEvent $event)
    {
        $cart = $this
            ->cartWrapper
            ->get();

        $order = $this
            ->cartOrderTransformer
            ->createOrderFromCart($cart);

        $event
            ->getPaymentBridge()
            ->setOrder($order);
    }
}
