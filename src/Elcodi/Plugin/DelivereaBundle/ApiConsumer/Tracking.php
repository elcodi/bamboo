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
 * Class Tracking
 */
class Tracking
{
    /**
     * @var GuzzleClient
     *
     * A guzzle client
     */
    protected $guzzleclient;

    /**
     * @var array
     *
     * All the deliverea api urls.
     */
    protected $delivereaUrls;

    /**
     * Builds a new clas.
     *
     * @param GuzzleClient $guzzleclient  A guzzle client.
     * @param array        $delivereaUrls All the deliverea api urls.
     */
    public function __construct(
        GuzzleClient $guzzleclient,
        array $delivereaUrls
    ) {
        $this->guzzleclient = $guzzleclient;
        $this->delivereaUrls = $delivereaUrls;
    }

    /**
     * Get the tracking info from the deliverea api.
     *
     * More info: http://www.deliverea.com/es/api/#get-shipment-tracking
     *
     * @param string $username     The username.
     * @param string $apiKey       The api key.
     * @param string $delivereaRef The deliverea ref.
     *
     * @return array|mixed
     */
    public function getTracking(
        $username,
        $apiKey,
        $delivereaRef
    ) {
        try {
            /** @var GuzzleResponse $apiResponse */
            $apiResponse = $this->guzzleclient->post(
                $this->delivereaUrls['get_tracking'],
                [
                    'auth' => [$username, $apiKey],
                    'body' => ['dlvr_ref' => $delivereaRef],
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
     * Get the tracking for multiple shipments.
     *
     * More info: http://www.deliverea.com/es/api/#get-shipments-tracking
     *
     * @todo To be implemented
     */
    public function getTrackings()
    {
    }
}
