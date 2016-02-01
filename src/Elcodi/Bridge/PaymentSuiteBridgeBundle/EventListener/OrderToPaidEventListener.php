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

use Doctrine\Common\Persistence\ObjectManager;
use PaymentSuite\PaymentCoreBundle\Event\Abstracts\AbstractPaymentEvent;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\StateTransitionMachine\Machine\MachineManager;

/**
 * Class OrderToPaidEventListener
 */
class OrderToPaidEventListener
{
    /**
     * @var MachineManager
     *
     * MachineManager for payment
     */
    private $paymentMachineManager;

    /**
     * @var ObjectManager
     *
     * Order object manager
     */
    private $orderObjectManager;

    /**
     * @var ObjectManager
     *
     * StateLine object manager
     */
    private $stateLineObjectManager;

    /**
     * Construct method
     *
     * @param MachineManager $paymentMachineManager  Machine manager for payment
     * @param ObjectManager  $orderObjectManager     Order object manager
     * @param ObjectManager  $stateLineObjectManager StateLine object manager
     */
    public function __construct(
        MachineManager $paymentMachineManager,
        ObjectManager $orderObjectManager,
        ObjectManager $stateLineObjectManager
    ) {
        $this->paymentMachineManager = $paymentMachineManager;
        $this->orderObjectManager = $orderObjectManager;
        $this->stateLineObjectManager = $stateLineObjectManager;
    }

    /**
     * Completes the payment process when the payment.order.success event is raised.
     *
     * This means that we can change the order state to ACCEPTED
     *
     * @param AbstractPaymentEvent $event
     */
    public function setOrderToPaid(AbstractPaymentEvent $event)
    {
        $order = $event
            ->getPaymentBridge()
            ->getOrder();

        if (!$order instanceof OrderInterface) {
            throw new \LogicException(
                'Cannot retrieve Order from PaymentBridge'
            );
        }

        /**
         * We create the new entry in the payment state machine
         */
        $stateLineStack = $this
            ->paymentMachineManager
            ->transition(
                $order,
                $order->getPaymentStateLineStack(),
                'pay',
                'Order paid using ' . $event
                    ->getPaymentMethod()
                    ->getPaymentName()
            );

        $order->setPaymentStateLineStack($stateLineStack);

        /**
         * We save all the data
         */
        $this
            ->stateLineObjectManager
            ->persist($stateLineStack->getLastStateLine());

        $this
            ->stateLineObjectManager
            ->flush($stateLineStack->getLastStateLine());

        $this
            ->stateLineObjectManager
            ->flush($order);
    }
}
