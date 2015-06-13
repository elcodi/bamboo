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

use Elcodi\Plugin\DelivereaBundle\ApiConsumer\Label as LabelApiConsumer;
use Elcodi\Plugin\DelivereaBundle\Entity\DelivereaShipment;

class Label
{
    /**
     * @var LabelApiConsumer
     *
     * The label api consumer
     */
    protected $labelApiConsumer;

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
     * Builds a new class.
     *
     * @param LabelApiConsumer $LabelApiConsumer The label api consumer.
     * @param String           $user             The deliverea user.
     * @param String           $apiKey           The deliverea api key.
     */
    public function __construct(
        LabelApiConsumer $LabelApiConsumer,
        $user,
        $apiKey
    ) {
        $this->labelApiConsumer = $LabelApiConsumer;
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
    public function getLabel(
        $delivereaRef
    ) {
        $apiResponse = $this
            ->labelApiConsumer
            ->getLabel(
                $this->user,
                $this->apiKey,
                $delivereaRef
            );

        if ('ok' == $apiResponse['status']) {
            $base64Label = $apiResponse['data']['label_raw'];

            return base64_decode($base64Label);
        }

        return false;
    }
}
