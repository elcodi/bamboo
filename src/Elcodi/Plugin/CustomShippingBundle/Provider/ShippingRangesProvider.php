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

namespace Elcodi\Plugin\CustomShippingBundle\Provider;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Zone\Services\ZoneMatcher;
use Elcodi\Plugin\CustomShippingBundle\ElcodiShippingRangeTypes;
use Elcodi\Plugin\CustomShippingBundle\Entity\Interfaces\CarrierInterface;
use Elcodi\Plugin\CustomShippingBundle\Entity\Interfaces\ShippingRangeInterface;
use Elcodi\Plugin\CustomShippingBundle\Repository\CarrierRepository;

/**
 * Class ShippingRangesProvider
 */
class ShippingRangesProvider
{
    /**
     * @var CarrierRepository
     *
     * carrierRepository
     */
    protected $carrierRepository;

    /**
     * @var CurrencyConverter
     *
     * currencyConverter
     */
    protected $currencyConverter;

    /**
     * @var ZoneMatcher
     *
     * ZoneMatcher
     */
    protected $zoneMatcher;

    /**
     * Construct method
     *
     * @param CarrierRepository $carrierRepository Carrier Repository
     * @param CurrencyConverter $currencyConverter Currency Converter
     * @param ZoneMatcher       $zoneMatcher       Zone matcher
     */
    public function __construct(
        CarrierRepository $carrierRepository,
        CurrencyConverter $currencyConverter,
        ZoneMatcher $zoneMatcher
    ) {
        $this->carrierRepository = $carrierRepository;
        $this->currencyConverter = $currencyConverter;
        $this->zoneMatcher = $zoneMatcher;
    }

    /**
     * Given a Cart, return a set of ShippingRanges satisfied.
     *
     * @param CartInterface $cart Cart
     *
     * @return ShippingRangeInterface[] Set of carriers ranges satisfied
     */
    public function getAllShippingRangesSatisfiedWithCart(CartInterface $cart)
    {
        $availableCarriers = $this
            ->carrierRepository
            ->findBy([
                'enabled' => true,
            ]);

        $satisfiedShippingRanges = [];

        foreach ($availableCarriers as $carrier) {
            $satisfiedShippingRanges = array_merge(
                $satisfiedShippingRanges,
                $this->getShippingRangesSatisfiedByCart(
                    $cart,
                    $carrier
                )
            );
        }

        return $satisfiedShippingRanges;
    }

    /**
     * Return the first Carrier's ShippingRange satisfied by a Cart.
     *
     * If none is found, return false
     *
     * @param CartInterface    $cart
     * @param CarrierInterface $carrier
     *
     * @return ShippingRangeInterface[] ShippingRanges satisfied by Cart
     */
    private function getShippingRangesSatisfiedByCart(
        CartInterface $cart,
        CarrierInterface $carrier
    ) {
        $shippingRanges = $carrier->getRanges();
        $validShippingRanges = [];

        foreach ($shippingRanges as $shippingRange) {
            $shippingRangeSatisfied = $this->isShippingRangeSatisfiedByCart(
                $cart,
                $shippingRange
            );

            if ($shippingRangeSatisfied) {
                $validShippingRanges[] = $shippingRange;
            }
        }

        return $validShippingRanges;
    }

    /**
     * Return if Carrier Range is satisfied by cart
     *
     * @param CartInterface          $cart
     * @param ShippingRangeInterface $shippingRange
     *
     * @return boolean Carrier Range is satisfied by cart
     */
    private function isShippingRangeSatisfiedByCart(
        CartInterface $cart,
        ShippingRangeInterface $shippingRange
    ) {
        if ($shippingRange->getType() === ElcodiShippingRangeTypes::TYPE_PRICE) {
            return $this->isShippingPriceRangeSatisfiedByCart($cart, $shippingRange);
        } elseif ($shippingRange->getType() === ElcodiShippingRangeTypes::TYPE_WEIGHT) {
            return $this->isShippingWeightRangeSatisfiedByCart($cart, $shippingRange);
        }

        return false;
    }

    /**
     * Given ShippingPriceRange is satisfied by a cart
     *
     * @param CartInterface          $cart          Cart
     * @param ShippingRangeInterface $shippingRange Carrier Range
     *
     * @return boolean ShippingRange is satisfied by cart
     */
    private function isShippingPriceRangeSatisfiedByCart(
        CartInterface $cart,
        ShippingRangeInterface $shippingRange
    ) {
        $cartPrice = $cart->getPurchasableAmount();
        $cartPriceCurrency = $cartPrice->getCurrency();
        $shippingRangeFromPrice = $shippingRange->getFromPrice();
        $shippingRangeToPrice = $shippingRange->getToPrice();

        return
            $this->isShippingRangeZonesSatisfiedByCart($cart, $shippingRange) &&
            (
                $this
                    ->currencyConverter
                    ->convertMoney($shippingRangeFromPrice, $cartPriceCurrency)
                    ->compareTo($cartPrice) <= 0
            ) &&
            (
                $this
                    ->currencyConverter
                    ->convertMoney($shippingRangeToPrice, $cartPriceCurrency)
                    ->compareTo($cartPrice) > 0
            );
    }

    /**
     * Given ShippingWeightRange is satisfied by a cart
     *
     * @param CartInterface          $cart          Cart
     * @param ShippingRangeInterface $shippingRange Carrier Range
     *
     * @return boolean ShippingRange is satisfied by cart
     */
    private function isShippingWeightRangeSatisfiedByCart(
        CartInterface $cart,
        ShippingRangeInterface $shippingRange
    ) {
        $cartWeight = $cart->getWeight();
        $cartRangeFromWeight = $shippingRange->getFromWeight();
        $cartRangeToWeight = $shippingRange->getToWeight();

        return
            $this->isShippingRangeZonesSatisfiedByCart($cart, $shippingRange) &&
            is_numeric($cartRangeFromWeight) &&
            is_numeric($cartRangeToWeight) &&
            $cartRangeFromWeight >= 0 &&
            $cartRangeToWeight >= 0 &&
            $cartWeight >= $cartRangeFromWeight &&
            $cartWeight < $cartRangeToWeight;
    }

    /**
     * Given ShippingRange zones are satisfied by a cart,
     *
     * @param CartInterface          $cart          Cart
     * @param ShippingRangeInterface $shippingRange Carrier Range
     *
     * @return boolean ShippingRange is satisfied by cart
     */
    private function isShippingRangeZonesSatisfiedByCart(
        CartInterface $cart,
        ShippingRangeInterface $shippingRange
    ) {
        $deliveryAddress = $cart->getDeliveryAddress();
        $shippingRange->getToZone()->getName();

        return
            $deliveryAddress === null ||
            $this
                ->zoneMatcher
                ->isAddressContainedInZone(
                    $deliveryAddress,
                    $shippingRange->getToZone()
                );
    }
}
