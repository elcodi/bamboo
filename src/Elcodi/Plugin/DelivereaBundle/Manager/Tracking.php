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

namespace Elcodi\Plugin\DelivereaBundle\Manager;

use Elcodi\Plugin\DelivereaBundle\ApiConsumer\Tracking as TrackingApiConsumer;
use Elcodi\Plugin\DelivereaBundle\Entity\DelivereaShipment;
use Elcodi\Plugin\DelivereaBundle\Repository\DelivereaShipmentRepository;

/**
 * Class Tracking
 */
class Tracking
{
    /**
     * @var TrackingApiConsumer
     *
     * The label api consumer
     */
    protected $trackingApiConsumer;

    /**
     * @var string
     *
     * The deliverea user
     */
    protected $user;

    /**
     * @var string
     *
     * The deliverea api key
     */
    protected $apiKey;
    /**
     * @var DelivereaShipmentRepository
     *
     * The deliverea shipment repository
     */
    private $delivereaShipmentRepository;

    /**
     * Builds a new class.
     *
     * @param TrackingApiConsumer         $TrackingApiConsumer         The tracking api consumer.
     * @param DelivereaShipmentRepository $delivereaShipmentRepository The deliverea shipment repository
     * @param String                      $user                        The deliverea user.
     * @param String                      $apiKey                      The deliverea api key.
     */
    public function __construct(
        TrackingApiConsumer $TrackingApiConsumer,
        DelivereaShipmentRepository $delivereaShipmentRepository,
        $user,
        $apiKey
    ) {
        $this->trackingApiConsumer = $TrackingApiConsumer;
        $this->delivereaShipmentRepository = $delivereaShipmentRepository;
        $this->user = $user;
        $this->apiKey = $apiKey;
    }

    /**
     * Creates a new shipment
     *
     * @param string $delivereaRef The deliverea reference.
     *
     * @return bool|DelivereaShipment
     */
    public function getTracking(
        $delivereaRef
    ) {
        $apiResponse = $this
            ->trackingApiConsumer
            ->getTracking(
                $this->user,
                $this->apiKey,
                $delivereaRef
            );

        if ('ok' == $apiResponse['status']) {
            $carrierInfo = $this->collectCarrierInfo($delivereaRef);
            $trackingInfo = $this->collectTrackingInfo($apiResponse);

            return array_merge($carrierInfo, $trackingInfo);
        }

        return false;
    }

    /**
     * Collects tracking info.
     *
     * @param array $apiResponse The api tracking response.
     *
     * @return array
     */
    private function collectTrackingInfo(array $apiResponse)
    {
        $trackingInfo = [
            'status' => $apiResponse['data']['tracking_name'],
            'code' => $apiResponse['data']['tracking_code'],
        ];

        foreach ($apiResponse['data']['tracking_history'] as $trackingHistory) {
            $trackingInfo['history'][] = [
                'status' => $trackingHistory['tracking_name'],
                'code' => $trackingHistory['tracking_code'],
                'details' => $trackingHistory['tracking_details'],
                'time' => new \DateTime($trackingHistory['tracking_date']),
            ];
        }

        return $trackingInfo;
    }

    /**
     * Collects the carrier info.
     *
     * @param string $delivereaRef The deliverea reference.
     *
     * @return array
     */
    private function collectCarrierInfo($delivereaRef)
    {
        /** @var DelivereaShipment $delivereaShipping */
        $delivereaShipping = $this
            ->delivereaShipmentRepository
            ->findOneBy(
                ['deliverea_shipping_ref' => $delivereaRef]
            );

        return [
            'carrier' => $delivereaShipping->getCarrier(),
            'carrierRef' => $delivereaShipping->getCarrierShippingRef(),
        ];
    }
}
