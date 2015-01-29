<?php

/*
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

namespace Elcodi\Store\PaymentBridgeBundle\Services;

use PaymentSuite\PaymentCoreBundle\Services\Interfaces\PaymentBridgeInterface;

use Elcodi\Component\Cart\Entity\Order;
use Elcodi\Component\Cart\Entity\OrderLine;
use Elcodi\Component\Cart\Repository\OrderRepository;
use Elcodi\Component\Currency\Entity\Money;

/**
 * Class PaymentBridge
 */
class PaymentBridge implements PaymentBridgeInterface
{
    /**
     * @var Order
     *
     * Order object
     */
    protected $order;

    /**
     * @var OrderRepository
     *
     * Order repository
     */
    protected $orderRepository;

    /**
     * @param OrderRepository $orderRepository Order repository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

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
        $this->order = $this
            ->orderRepository
            ->find($orderId);

        return $this->order;
    }

    /**
     * Get the currency in which the order is paid
     *
     * @throws \LogicException
     *
     * @return string
     */
    public function getCurrency()
    {
        $amount = $this->order->getAmount();

        if ($amount instanceof Money) {
            $currency = $amount->getCurrency();

            return $currency->getIso();
        }

        throw new \LogicException(
            sprintf(
                'Invalid Currency for Order [%d]',
                $this->getOrderId()
            )
        );
    }

    /**
     * Get total order amount in cents
     *
     * @return integer
     */
    public function getAmount()
    {
        $amount = $this->order->getAmount();

        if ($amount instanceof Money) {
            return $this
                ->order
                ->getAmount()
                ->getAmount();
        }

        throw new \LogicException(
            sprintf(
                'Invalid Amount for Order [%d]',
                $this->getOrderId()
            )
        );
    }

    /**
     * Get extra data
     *
     * Returns the order lines as array in the following form
     *
     * [
     *   1 => [ 'item' => 'Item 1', 'amount' => 1234, 'currency_code' => 'EUR ],
     *   2 => [ 'item_name' => 'Item 2', 'item_amount' => 2345, 'item_currency_code' => 'EUR ],
     * ]
     *
     * @return array
     */
    public function getExtraData()
    {
        $extraData = [];

        if ($this->order instanceof Order) {
            /**
             * @var OrderLine $orderLine
             */
            foreach ($this->order->getOrderLines() as $orderLine) {

                $orderLineArray = [];
                $orderLineArray['item_name'] = $orderLine
                    ->getPurchasable()
                    ->getName();

                /*
                 * Elcodi stores amounts in integer cents (10USD = 1000)
                 * but Paypal expects decimal (10.00USD)
                 */
                $orderLineArray['amount'] = $orderLine
                    ->getAmount()
                    ->getAmount() / 100;

                $orderLineArray['item_currency_code'] = $orderLine
                    ->getAmount()
                    ->getCurrency()
                    ->getIso();

                $orderLineArray['quantity'] = $orderLine->getQuantity();

                $extraData['items'][$orderLine->getId()] = $orderLineArray;
            }
        }

        return $extraData;
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
