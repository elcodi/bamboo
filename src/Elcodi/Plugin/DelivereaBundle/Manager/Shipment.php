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

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Geo\Factory\AddressViewFactory;
use Elcodi\Plugin\DelivereaBundle\ApiConsumer\Shipment as ShipmentApiConsumer;
use Elcodi\Plugin\DelivereaBundle\DelivereaTrackingCodes;
use Elcodi\Plugin\DelivereaBundle\Entity\DelivereaShipment;
use Elcodi\Plugin\DelivereaBundle\Factory\DelivereaShippingFactory;

/**
 * Class Shipment
 */
class Shipment
{
    /**
     * @var ShipmentApiConsumer
     *
     * The shipping api consumer
     */
    protected $shipmentApiConsumer;

    /**
     * @var AddressViewFactory
     *
     * An address view factory
     */
    protected $addressViewFactory;

    /**
     * @var DelivereaShippingFactory
     *
     * A shipping factory.
     */
    protected $delivereaShippingFactory;

    /**
     * @var ObjectManager
     *
     * A deliverea shipment object manager.
     */
    private $delivereaShipmentManager;

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
     * @var string
     *
     * The deliverea from address ID.
     */
    protected $delivereaFromAddressId;

    /**
     * @var string
     *
     * The deliverea service type.
     */
    protected $delivereaServiceType;

    /**
     * @var string
     *
     * The deliverea carrier code.
     */
    protected $delivereaCarrierCode;

    /**
     * @var string
     *
     * The deliverea service code.
     */
    protected $delivereaServiceCode;

    /**
     * Builds a new class.
     *
     * @param ShipmentApiConsumer      $shipmentApiConsumer      The shipment api consumer.
     * @param AddressViewFactory       $addressViewFactory       An address view factory.
     * @param DelivereaShippingFactory $delivereaShippingFactory A shipping factory.
     * @param ObjectManager            $delivereaShipmentManager A deliverea shipment object manager.
     * @param String                   $user                     The deliverea user.
     * @param String                   $apiKey                   The deliverea api key.
     * @param String                   $delivereaFromAddressId   The deliverea from address ID.
     * @param String                   $delivereaServiceType     The deliverea service type.
     * @param String                   $delivereaCarrierCode     The deliverea carrier code.
     * @param String                   $delivereaServiceCode     The deliverea service code.
     */
    public function __construct(
        ShipmentApiConsumer $shipmentApiConsumer,
        AddressViewFactory $addressViewFactory,
        DelivereaShippingFactory $delivereaShippingFactory,
        ObjectManager $delivereaShipmentManager,
        $user,
        $apiKey,
        $delivereaFromAddressId,
        $delivereaServiceType,
        $delivereaCarrierCode,
        $delivereaServiceCode
    ) {
        $this->shipmentApiConsumer = $shipmentApiConsumer;
        $this->addressViewFactory = $addressViewFactory;
        $this->delivereaShippingFactory = $delivereaShippingFactory;
        $this->delivereaShipmentManager = $delivereaShipmentManager;
        $this->user = $user;
        $this->apiKey = $apiKey;
        $this->delivereaFromAddressId = $delivereaFromAddressId;
        $this->delivereaServiceType = $delivereaServiceType;
        $this->delivereaCarrierCode = $delivereaCarrierCode;
        $this->delivereaServiceCode = $delivereaServiceCode;
    }

    /**
     * Creates a new shipment
     *
     * @param OrderInterface $order The order for the shipment.
     *
     * @return bool|DelivereaShipment
     */
    public function newShipment(OrderInterface $order)
    {
        $clientShipmentId = \time() . $order->getId();

        $toAddress = $order
            ->getDeliveryAddress();

        $toName = sprintf(
            '%s %s',
            $toAddress->getRecipientName(),
            $toAddress->getRecipientSurname()
        );

        $toAddressView = $this
            ->addressViewFactory
            ->create($toAddress);

        $countryIso = $toAddressView
            ->getCountryInfo()
            ->getCode();

        $toStreetName = $toAddressView
            ->getStreetName();

        $toCity = $toAddressView
            ->getCityInfo()
            ->getName();

        $apiResponse = $this
            ->shipmentApiConsumer
            ->newShipment(
                $this->user,
                $this->apiKey,
                $order->getQuantity(),
                $this->delivereaFromAddressId,
                $toName,
                $toStreetName,
                $toCity,
                $toAddress->getPostalcode(),
                $countryIso,
                date('Y-m-d'),
                $this->delivereaServiceType,
                $this->delivereaCarrierCode,
                $this->delivereaServiceCode,
                $clientShipmentId
            );

        if ('ok' == $apiResponse['status']) {
            $delivereaShipping = $this
                ->delivereaShippingFactory
                ->create();

            $carrier = constant(
                'Elcodi\Plugin\DelivereaBundle\DelivereaCarrierCodes::'
                . $apiResponse['data']['carrier_code']
            );

            $delivereaShipping
                ->setOrder($order)
                ->setDelivereaShippingref($apiResponse['data']['shipping_dlvr_ref'])
                ->setClientShippingRef($clientShipmentId)
                ->setCarrierShippingRef($apiResponse['data']['shipping_carrier_ref'])
                ->setCarrier($carrier)
                ->setService($apiResponse['data']['service_code']);

            $this->delivereaShipmentManager->persist($delivereaShipping);
            $this->delivereaShipmentManager->flush($delivereaShipping);

            return $delivereaShipping;
        }

        return false;
    }
}
