<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\PaymentBridgeBundle\Services;

use PaymentSuite\PaymentCoreBundle\Services\Interfaces\PaymentBridgeInterface;

/**
 * Class PaymentBridge
 */
class PaymentBridge implements PaymentBridgeInterface
{
    /**
     * @var Object
     *
     * Order object
     */
    protected $order;

    /**
     * Set order to OrderWrapper
     *
     * @var Object $order Order element
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * Return order
     *
     * @return Object order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Return order identifier value
     *
     * @return integer
     */
    public function getOrderId()
    {
        return $this->order->getId();
    }

    /**
     * Given an id, find Order
     *
     * @param integer $orderId Order id
     *
     * @return Object order
     */
    public function findOrder($orderId)
    {
        return null;
    }

    /**
     * Get the currency in which the order is paid
     *
     * @return string
     */
    public function getCurrency()
    {
        return 'USD';
    }

    /**
     * Get total order amount in cents
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->order->getAmount();
    }

    /**
     * Get extra data
     *
     * @return array
     */
    public function getExtraData()
    {
        return [];
    }

    /**
     * Get extra data
     *
     * @return array
     */
    public function isOrderPaid()
    {
        return true;
    }
}
