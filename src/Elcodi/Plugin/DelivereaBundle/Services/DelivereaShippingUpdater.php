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

use Elcodi\Plugin\DelivereaBundle\Entity\DelivereaShipment;
use Elcodi\Plugin\DelivereaBundle\Manager\Tracking as TrackingManager;

/**
 * Class DelivereaShippingUpdater
 */
class DelivereaShippingUpdater
{
    /**
     * @var TrackingManager
     *
     * The tracking manager to get tracking info.
     */
    private $trackingManager;

    /**
     * @var ObjectManager
     *
     * The entity manager for the deliverea shipment entity.
     */
    private $delivereaShipmentEntityManager;

    /**
     * @var ShippingStateConverter
     *
     * The shipping state converter.
     */
    private $shippingStateConverter;

    /**
     * Builds a new class.
     *
     * @param TrackingManager        $trackingManager                The tracking manager to get tracking info.
     * @param ObjectManager          $delivereaShipmentEntityManager The entity manager for the deliverea shipment entity.
     * @param ShippingStateConverter $shippingStateConverter         The shipping state converter.
     */
    public function __construct(
        TrackingManager $trackingManager,
        ObjectManager $delivereaShipmentEntityManager,
        ShippingStateConverter $shippingStateConverter
    ) {
        $this->trackingManager = $trackingManager;
        $this->delivereaShipmentEntityManager = $delivereaShipmentEntityManager;
        $this->shippingStateConverter = $shippingStateConverter;
    }

    /**
     * Updates the state for a deliverea shipping
     *
     * @param DelivereaShipment $shipment The shipment to update.
     *
     * @return bool If the shipping has been updated
     */
    public function updateState(DelivereaShipment $shipment)
    {
        $trackingInfo = $this
            ->trackingManager
            ->getTracking($shipment->getDelivereaShippingRef());

        $statusCode = $trackingInfo['code'];
        $currentStatus = $this
            ->shippingStateConverter
            ->fromDelivereaCodeToShippingStatus($statusCode);

        $isUpdated = false;
        if ($shipment->getStatus() != $currentStatus) {
            $isUpdated = true;

            $shipment->setStatus($currentStatus);
            $this->delivereaShipmentEntityManager->persist($shipment);
            $this->delivereaShipmentEntityManager->flush($shipment);
        }

        return $isUpdated;
    }
}
