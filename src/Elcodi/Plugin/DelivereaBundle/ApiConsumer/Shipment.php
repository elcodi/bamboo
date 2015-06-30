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

namespace Elcodi\Plugin\DelivereaBundle\ApiConsumer;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Message\Response as GuzzleResponse;

/**
 * Class Shipment
 */
class Shipment
{
    /**
     * @var GuzzleClient
     *
     * A guzzle client.
     */
    protected $guzzleclient;

    /**
     * @var array
     *
     * The deliverea urls
     */
    protected $delivereaUrls;

    /**
     * Builds a new class
     *
     * @param GuzzleClient $guzzleclient  A guzzle client.
     * @param array        $delivereaUrls The deliverea urls.
     */
    public function __construct(
        GuzzleClient $guzzleclient,
        array $delivereaUrls
    ) {
        $this->guzzleclient = $guzzleclient;
        $this->delivereaUrls = $delivereaUrls;
    }

    /**
     * Consumes the new shipment deliverea api method.
     *
     * More info: http://www.deliverea.com/es/api/#new-shipment
     *
     * @param string $username          The username.
     * @param string $apiKey            The api key.
     * @param string $parcelNumber      The number of parcels.
     * @param string $fromAddressId     The address where the shipment comes from.
     * @param string $toName            The name of the person sent to.
     * @param string $toStreetName      The street to send to.
     * @param string $toCity            The city to send to.
     * @param string $toZipCode         A zip code.
     * @param string $toCountryCode     A country code.
     * @param string $shippingDate      A shipping date.
     * @param string $serviceType       A service type.
     * @param string $carrierCode       A carrier code.
     * @param string $serviceCode       A service code.
     * @param string $shippingClientRef A client shipping ref (Must be unique).
     *
     * @return array|mixed
     */
    public function newShipment(
        $username,
        $apiKey,
        $parcelNumber,
        $fromAddressId,
        $toName,
        $toStreetName,
        $toCity,
        $toZipCode,
        $toCountryCode,
        $shippingDate,
        $serviceType,
        $carrierCode,
        $serviceCode,
        $shippingClientRef
    ) {
        $postBody = [
            'parcel_number' => $parcelNumber,
            'from_address_id' => $fromAddressId,
            'to_name' => $toName,
            'to_street_name' => $toStreetName,
            'to_city' => $toCity,
            'to_zip_code' => $toZipCode,
            'to_country_code' => $toCountryCode,
            'shipping_date' => $shippingDate,
            'service_type' => $serviceType,
            'carrier_code' => $carrierCode,
            'service_code' => $serviceCode,
            'shipping_client_ref' => $shippingClientRef,
        ];

        try {
            /** @var GuzzleResponse $apiResponse */
            $apiResponse = $this->guzzleclient->post(
                $this->delivereaUrls['new_shipment'],
                [
                    'auth' => [$username, $apiKey],
                    'body' => $postBody,
                ]
            );

            $jsonResponse = $apiResponse
                ->getBody()
                ->getContents();

            $response = json_decode($jsonResponse, true);
        } catch (\Exception $e) {
            $response = [
                'status' => 'err',
                'message' => $e->getMessage(),
            ];
        }

        return $response;
    }

    /**
     * Gets the shipment info.
     *
     * More info: http://www.deliverea.com/es/api/#get-shipment
     *
     * @todo To be implemented
     *
     * @param string $username     The username.
     * @param string $password     The password.
     * @param string $delivereaRef The deliverea ref.
     */
    public function getShipmentInfo(
        $username,
        $password,
        $delivereaRef
    ) {
    }

    /**
     * List the shipments
     *
     * More info: http://www.deliverea.com/es/api/#get-shipments
     *
     * @todo To be implemented
     */
    public function listShipments()
    {
    }

    /**
     * Cancels a shipment
     *
     * More info: http://www.deliverea.com/es/api/#cancel-shipment
     *
     * @todo To be implemented
     */
    public function cancelShipment()
    {
    }
}
