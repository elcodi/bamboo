<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi.com
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

namespace Elcodi\Bridge\PaymentSuiteBridgeBundle\Services;

use LogicException;
use PaymentSuite\PaymentCoreBundle\Services\Interfaces\PaymentBridgeInterface;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Entity\Order;
use Elcodi\Component\Cart\Entity\OrderLine;
use Elcodi\Component\Cart\Repository\OrderRepository;
use Elcodi\Component\Cart\Wrapper\CartWrapper;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Product\NameResolver\Interfaces\PurchasableNameResolverInterface;

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
    private $order;

    /**
     * @var OrderRepository
     *
     * Order repository
     */
    private $orderRepository;

    /**
     * @var CartWrapper
     *
     * Cart wrapper
     */
    private $cartWrapper;

    /**
     * @var CurrencyConverter
     *
     * Currency converter
     */
    private $currencyConverter;

    /**
     * @var PurchasableNameResolverInterface
     *
     * Purchasable name resolver
     */
    private $purchasableNameResolver;

    /**
     * @param OrderRepository                  $orderRepository         Order repository
     * @param CartWrapper                      $cartWrapper             Cart wrapper
     * @param CurrencyConverter                $currencyConverter       Currency converter
     * @param PurchasableNameResolverInterface $purchasableNameResolver Purchasable name resolver
     */
    public function __construct(
        OrderRepository $orderRepository,
        CartWrapper $cartWrapper,
        CurrencyConverter $currencyConverter,
        PurchasableNameResolverInterface $purchasableNameResolver
    ) {
        $this->orderRepository = $orderRepository;
        $this->cartWrapper = $cartWrapper;
        $this->currencyConverter = $currencyConverter;
        $this->purchasableNameResolver = $purchasableNameResolver;
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
     * @throws LogicException
     *
     * @return string
     */
    public function getCurrency()
    {
        /**
         * If there is no order yet we have
         * to pull the currency from the Cart
         */
        if (!$this->order instanceof OrderInterface) {
            return $this
                ->cartWrapper
                ->get()
                ->getAmount()
                ->getCurrency()
                ->getIso();
        }

        $amount = $this->order->getAmount();

        if ($amount instanceof Money) {
            $currency = $amount->getCurrency();

            return $currency->getIso();
        }

        throw new LogicException(
            sprintf(
                'Invalid Currency for Order [%d]',
                $this->getOrderId()
            )
        );
    }

    /**
     * Get total order amount.
     *
     * Money value-object amounts are stored as integers, representing
     * CENTS, so we have to divide by 100 since PaymentBridgeInterface
     * expects a decimal value
     *
     * @return integer
     */
    public function getAmount()
    {
        /**
         * Tweak to allow payment methods to access
         * amount and currency when an order has not
         * been created yet.
         *
         * If there is no order yet we have
         * to pull the amount from the Cart
         */
        if (!$this->order instanceof OrderInterface) {
            return $this
                ->cartWrapper
                ->get()
                ->getAmount()
                ->getAmount();
        }

        $amount = $this
            ->order
            ->getAmount();

        if ($amount instanceof Money) {
            return $this
                ->order
                ->getAmount()
                ->getAmount();
        }

        throw new LogicException(
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
        $orderDescription = [];

        if ($this->order instanceof Order) {
            $currency = $this
                ->order
                ->getAmount()
                ->getCurrency();

            /**
             * @var OrderLine $orderLine
             *
             * Line prices must be converted to the currency
             * of the Cart when they are defined in another
             * currency
             */
            foreach ($this->order->getOrderLines() as $orderLine) {
                $orderLineArray = [];

                $purchasable = $orderLine->getPurchasable();
                $orderLineName = $this
                    ->purchasableNameResolver
                    ->resolveName($purchasable);

                $orderLineArray['item_name'] = $orderLineName;

                $lineAmount = $orderLine->getPurchasableAmount();

                /*
                 * We need to convert any price to match
                 * current order currency
                 */
                $convertedAmount = $this
                    ->currencyConverter
                    ->convertMoney(
                        $lineAmount,
                        $currency
                    );

                $orderLineArray['amount'] = $convertedAmount
                    ->getAmount();

                /**
                 * Line items currency should always match
                 * the one from the order
                 */
                $orderLineArray['item_currency_code'] = $this->getCurrency();

                $orderDescription[] = $orderLineName;
                $orderLineArray['quantity'] = $orderLine->getQuantity();

                $extraData['items'][$orderLine->getId()] = $orderLineArray;
            }

            // We add the shipping costs as a new "shadow" line in the extraData structure.
            $shippingAmount = $this
                ->order
                ->getShippingAmount();

            if ($shippingAmount->isGreaterThan(Money::create(0, $shippingAmount->getCurrency()))) {
                $extraData['items'][] = [
                    'item_name'          => 'shipping',
                    'item_currency_code' => $shippingAmount->getCurrency(),
                    'quantity'           => 1,
                    'amount'             => $shippingAmount->getAmount(),
                ];
            }

            // We add the coupon discounts as a new "shadow" line in the extraData structure.
            $couponAmount = $this
                ->order
                ->getCouponAmount();

            if ($couponAmount->isGreaterThan(Money::create(0, $couponAmount->getCurrency()))) {
                $extraData['discount_amount_cart'] = $couponAmount->getAmount();
            }

            $extraData['order_description'] = implode(" - ", $orderDescription);
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
        return $this->order instanceof OrderInterface
            ? $this
                ->order
                ->getPaymentStateLineStack()
                ->getLastStateLine()
                ->getName('paid')
            : false;
    }
}
