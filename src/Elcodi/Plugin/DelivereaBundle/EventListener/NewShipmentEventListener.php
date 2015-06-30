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

namespace Elcodi\Plugin\DelivereaBundle\EventListener;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\StateTransitionMachine\Event\TransitionEvent;
use Elcodi\Plugin\DelivereaBundle\Manager\Shipment as ShipmentManager;
use Elcodi\Plugin\DelivereaBundle\Services\ShippingMethodChecker;

/**
 * Class NewShipmentEventListener
 */
class NewShipmentEventListener
{
    /**
     * @var ShipmentManager
     *
     * A shipment manager service
     */
    protected $shipmentManagerService;

    /**
     * @var ShippingMethodChecker
     *
     * A shipment method checker
     */
    protected $shippingMethodChecker;

    /**
     * Builds a new class
     *
     * @param ShipmentManager       $shipmentService       A shipment manager service
     * @param ShippingMethodChecker $shippingMethodChecker A shipment method checker
     */
    public function __construct(
        ShipmentManager $shipmentService,
        ShippingMethodChecker $shippingMethodChecker
    ) {
        $this->shipmentManagerService = $shipmentService;
        $this->shippingMethodChecker = $shippingMethodChecker;
    }

    /**
     * When an order is processed it creates a new shipment if belongs to deliverea.
     *
     * @param TransitionEvent $transitionEvent The transition event.
     */
    public function onOrderProcessed(TransitionEvent $transitionEvent)
    {
        /** @var OrderInterface $order */
        $order = $transitionEvent->getObject();
        if ($this->shippingMethodChecker->orderHasDelivereaShipping($order)) {
            $this->shipmentManagerService->newShipment($order);
        }
    }
}
