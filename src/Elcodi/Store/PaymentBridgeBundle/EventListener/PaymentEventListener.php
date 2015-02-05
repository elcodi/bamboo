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
 */

namespace Elcodi\Store\PaymentBridgeBundle\EventListener;

use PaymentSuite\PaymentCoreBundle\Event\PaymentOrderLoadEvent;
use PaymentSuite\PaymentCoreBundle\Event\PaymentOrderSuccessEvent;

use Elcodi\Component\Cart\Entity\Order;
use Elcodi\Component\Cart\Transformer\CartOrderTransformer;
use Elcodi\Component\Cart\Wrapper\CartWrapper;
use Elcodi\Component\StateTransitionMachine\Machine\MachineManager;

/**
 * Class PaymentEventListener
 */
class PaymentEventListener
{
    /**
     * @var CartWrapper
     *
     * Cart Wrapper
     */
    protected $cartWrapper;

    /**
     * @var CartOrderTransformer
     *
     * Cart to Order transformer
     */
    protected $cartOrderTransformer;

    /**
     * @var MachineManager
     *
     * MachineManager
     */
    protected $orderStateTransitionMachineManager;

    /**
     * Construct method
     *
     * @param CartWrapper          $cartWrapper                        Cart Wrapper
     * @param CartOrderTransformer $cartOrderTransformer               Cart Order Transformer
     * @param MachineManager       $orderStateTransitionMachineManager Order State Transition Machine manager
     */
    public function __construct(
        CartWrapper $cartWrapper,
        CartOrderTransformer $cartOrderTransformer,
        MachineManager $orderStateTransitionMachineManager
    ) {
        $this->cartWrapper = $cartWrapper;
        $this->cartOrderTransformer = $cartOrderTransformer;
        $this->orderStateTransitionMachineManager = $orderStateTransitionMachineManager;
    }

    /**
     * Create order given current cart. This event is only for pushing the new
     * Order to the payment infrastructure
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

    /**
     * Completes the payment process when the payment.order.success event is raised.
     *
     * This means that we can change the order state to ACCEPTED
     *
     * @param PaymentOrderSuccessEvent $event
     */
    public function onPaymentOrderSuccess(PaymentOrderSuccessEvent $event)
    {
        $order = $event
            ->getPaymentBridge()
            ->getOrder();

        if (!$order instanceof Order) {
            throw new \LogicException(
                'Cannot retrieve Order from PaymentBridge'
            );
        }

        $this
            ->orderStateTransitionMachineManager
            ->transition(
                $order,
                'pay',
                'Order paid'
            );
    }
}
