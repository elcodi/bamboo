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
 * Class Label
 */
class Label
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
     * The deliverea API urls
     */
    protected $delivereaUrls;

    /**
     * Builds a new class
     *
     * @param GuzzleClient $guzzleclient  A guzzle client.
     * @param array        $delivereaUrls The deliverea API urls
     */
    public function __construct(
        GuzzleClient $guzzleclient,
        array $delivereaUrls
    ) {
        $this->guzzleclient = $guzzleclient;
        $this->delivereaUrls = $delivereaUrls;
    }

    /**
     * Consumes the get label method from the Deliverea API
     *
     * View more: http://www.deliverea.com/es/api/#get-label
     *
     * @param string $username     The username
     * @param string $apiKey       The api key
     * @param string $delivereaRef The deliverea ref
     *
     * @return array|mixed
     */
    public function getLabel(
        $username,
        $apiKey,
        $delivereaRef
    ) {
        try {
            /** @var GuzzleResponse $apiResponse */
            $apiResponse = $this->guzzleclient->post(
                $this->delivereaUrls['get_label'],
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
}
