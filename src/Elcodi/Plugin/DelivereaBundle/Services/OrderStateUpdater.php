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
use Elcodi\Plugin\DelivereaBundle\Manager\Tracking as TrackingManager;

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
     * @var TrackingManager
     *
     * The tracking manager to get tracking info.
     */
    private $trackingManager;

    /**
     * Builds a new class
     *
     * @param MachineManager         $shippingMachineManager The machine manager service.
     * @param ShippingStateConverter $shippingStateConverter The shipping state converter.
     * @param ObjectManager          $orderEntityManager     The order entity manager.
     * @param TrackingManager        $trackingManager        The tracking manager service.
     */
    public function __construct(
        MachineManager $shippingMachineManager,
        ShippingStateConverter $shippingStateConverter,
        ObjectManager $orderEntityManager,
        TrackingManager $trackingManager
    ) {
        $this->shippingMachineManager = $shippingMachineManager;
        $this->shippingStateConverter = $shippingStateConverter;
        $this->orderEntityManager = $orderEntityManager;
        $this->trackingManager = $trackingManager;
    }

    /**
     * Updates an order given the shipment status
     *
     * @param DelivereaShipment $shipment The shipment.
     */
    public function updateState(DelivereaShipment $shipment)
    {
        $order = $shipment->getOrder();
        $trackingInfo = $this
            ->trackingManager
            ->getTracking($shipment->getDelivereaShippingRef());

        $currentStatus = $this
            ->shippingStateConverter
            ->fromDelivereaCodeToShippingStatus($trackingInfo['code']);

        $orderCurrentShipmentStatus = $this
            ->shippingStateConverter
            ->getShippingStateFromDelivereaStatus($currentStatus);

        $orderLastShipmentStatus = $order
            ->getShippingStateLineStack()
            ->getLastStateLine()
            ->getName();

        if($orderCurrentShipmentStatus != $orderLastShipmentStatus)
        {
            try {
                $stateLineStack = $this
                    ->shippingMachineManager
                    ->reachState(
                        $order,
                        $order->getShippingStateLineStack(),
                        $orderCurrentShipmentStatus,
                        ''
                    );

                $order->setShippingStateLineStack($stateLineStack);
                $this->orderEntityManager->flush($order);
            } catch (StateNotReachableException $e) {
                trigger_error($e->getMessage());
            }
        }
    }
}