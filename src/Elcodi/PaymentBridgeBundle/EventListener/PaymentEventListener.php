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

namespace Elcodi\PaymentBridgeBundle\EventListener;

use PaymentSuite\PaymentCoreBundle\Event\PaymentOrderCreatedEvent;
use PaymentSuite\PaymentCoreBundle\Event\PaymentOrderDoneEvent;
use PaymentSuite\PaymentCoreBundle\Event\PaymentOrderLoadEvent;
use PaymentSuite\PaymentCoreBundle\Event\PaymentOrderSuccessEvent;

use Elcodi\Component\Cart\Entity\Order;
use Elcodi\Component\Cart\Repository\OrderRepository;
use Elcodi\Component\Cart\Services\OrderManager;
use Elcodi\Component\Cart\Transformer\CartOrderTransformer;
use Elcodi\Component\Cart\Wrapper\CartWrapper;

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
     * @var OrderManager
     *
     * Order Manager
     */
    protected $orderManager;

    /**
     * @var OrderRepository
     *
     * Order Repository
     */
    protected $orderRepository;

    /**
     * Construct method
     *
     * @param CartWrapper          $cartWrapper          Cart Wrapper
     * @param CartOrderTransformer $cartOrderTransformer Cart Order Transformer
     */
    public function __construct(
        CartWrapper $cartWrapper,
        CartOrderTransformer $cartOrderTransformer,
        OrderManager $orderManager,
        OrderRepository $orderRepository
    )
    {
        $this->cartWrapper = $cartWrapper;
        $this->cartOrderTransformer = $cartOrderTransformer;
        $this->orderManager = $orderManager;
        $this->orderRepository = $orderRepository;
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

        $this->orderManager->addStateToOrder($order, 'pending.payment');
    }

    /**
     * @param PaymentOrderCreatedEvent $event
     */
    public function onPaymentOrderCreated(PaymentOrderCreatedEvent $event)
    {

    }

    /**
     * @param PaymentOrderDoneEvent $paymentOrderDoneEvent
     */
    public function onPaymentOrderDone(PaymentOrderDoneEvent $paymentOrderDoneEvent)
    {
        // STORE THE TRANSACTION ID LOCALLY
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
        $order = $event->getPaymentBridge()->getOrder();

        if (!$order instanceof Order) {
            throw new \LogicException(
                'Cannot retrieve Order from PaymentBridge'
            );
        }

        $this->orderManager->addStateToOrder($order, 'accepted');
    }

}
