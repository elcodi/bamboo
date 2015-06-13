<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Plugin\DelivereaBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\StateTransitionMachine\Exception\StateNotReachableException;
use Elcodi\Component\StateTransitionMachine\Machine\MachineManager;
use Elcodi\Plugin\DelivereaBundle\Entity\DelivereaShipment;

/**
 * Class OrderStateUpdater
 */
class OrderStateUpdater
{
    /**
     * @var MachineManager
     *
     * The machine manager service
     */
    private $shippingMachineManager;
    /**
     * @var ShippingStateConverter
     *
     * The shipping state converter.
     */
    private $shippingStateConverter;
    /**
     * @var ObjectManager
     *
     * The order entity manager.
     */
    private $orderEntityManager;

    /**
     * Builds a new class
     *
     * @param MachineManager         $shippingMachineManager The machine manager service.
     * @param ShippingStateConverter $shippingStateConverter The shipping state converter.
     * @param ObjectManager          $orderEntityManager     The order entity manager.
     */
    public function __construct(
        MachineManager $shippingMachineManager,
        ShippingStateConverter $shippingStateConverter,
        ObjectManager $orderEntityManager
    ) {
        $this->shippingMachineManager = $shippingMachineManager;
        $this->shippingStateConverter = $shippingStateConverter;
        $this->orderEntityManager = $orderEntityManager;
    }

    /**
     * Updates an order given the shipment status
     *
     * @param DelivereaShipment $shipment The shipment.
     */
    public function updateState(DelivereaShipment $shipment)
    {
        $order = $shipment->getOrder();
        $currentStatus = $shipment->getStatus();

        try {
            $stateLineStack = $this
                ->shippingMachineManager
                ->reachState(
                    $order,
                    $order->getShippingStateLineStack(),
                    $this
                        ->shippingStateConverter
                        ->getShippingStateFromDelivereaStatus($currentStatus),
                    ''
                );

            $order->setShippingStateLineStack($stateLineStack);
            $this->orderEntityManager->flush($order);
        } catch (StateNotReachableException $e) {
            trigger_error($e->getMessage());
        }
    }
}
