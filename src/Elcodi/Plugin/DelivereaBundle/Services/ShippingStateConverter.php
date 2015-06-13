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

use Elcodi\Plugin\DelivereaBundle\DelivereaTrackingCodes;

/**
 * Class ShippingStateConverter
 */
class ShippingStateConverter
{
    /**
     * Converts a deliverea code in a shipping status.
     *
     * @param integer $delivereaCode A delivere code status
     *
     * @return string
     */
    public function fromDelivereaCodeToShippingStatus($delivereaCode)
    {
        $prefix = DelivereaTrackingCodes::CODE_PREFIX;

        return constant(
            sprintf(
                '%s%s%s',
                'Elcodi\Plugin\DelivereaBundle\DelivereaTrackingCodes::',
                $prefix,
                $delivereaCode
            )
        );
    }

    /**
     * Gets a shipping state from a deliverea status
     *
     * @param $delivereaStatus
     *
     * @return string
     */
    public function getShippingStateFromDelivereaStatus($delivereaStatus)
    {
        $status = 'preparing';
        switch ($delivereaStatus) {
            case DelivereaTrackingCodes::CODE01:
                $status = 'picked up by carrier';
                break;
            case DelivereaTrackingCodes::CODE02:
            case DelivereaTrackingCodes::CODE03:
            case DelivereaTrackingCodes::CODE04:
                $status = 'in delivery';
                break;
            case DelivereaTrackingCodes::CODE05:
                $status = 'delivered';
                break;
            case DelivereaTrackingCodes::CODE06:
            case DelivereaTrackingCodes::CODE07:
                $status = 'cancelled';
                break;
        }

        return $status;
    }
}
