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

namespace Elcodi\Plugin\CustomShippingBundle\Tests\UnitTest\Provider;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;
use Prophecy\Argument;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Currency\Entity\Currency;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Zone\Services\ZoneMatcher;
use Elcodi\Plugin\CustomShippingBundle\ElcodiShippingRangeTypes;
use Elcodi\Plugin\CustomShippingBundle\Entity\Interfaces\CarrierInterface;
use Elcodi\Plugin\CustomShippingBundle\Entity\Interfaces\ShippingRangeInterface;
use Elcodi\Plugin\CustomShippingBundle\Provider\ShippingRangesProvider;
use Elcodi\Plugin\CustomShippingBundle\Repository\CarrierRepository;

/**
 * Class ShippingRangesProviderTest
 */
class ShippingRangesProviderTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test getAllShippingRangesSatisfiedWithCart method
     *
     * @dataProvider dataGetAllShippingRangesSatisfiedWithCart
     */
    public function testGetAllShippingRangesSatisfiedWithCart(
        $withCarrier,
        $priceFrom,
        $priceTo,
        $priceRangePrice,
        $weightFrom,
        $weightTo,
        $weightRangePrice,
        $currencyConverterMultiplier,
        $hasResult
    ) {
        $shippingCollectEventListener = new ShippingRangesProvider(
            $this->getBuiltCarrierRepository(
                $withCarrier,
                $priceFrom,
                $priceTo,
                $priceRangePrice,
                $weightFrom,
                $weightTo,
                $weightRangePrice
            )->reveal(),
            $this->getCurrencyConverter($currencyConverterMultiplier)->reveal(),
            $this->getZoneMatcher()->reveal()
        );

        $shippingRanges = $shippingCollectEventListener->getAllShippingRangesSatisfiedWithCart(
            $this->getRevealedCart()
        );
        $this->assertCount($hasResult, $shippingRanges);
    }

    /**
     * Data for testGetAllShippingRangesSatisfiedWithCart
     */
    public function dataGetAllShippingRangesSatisfiedWithCart()
    {
        return [
            // Test with no carriers
            [
                false, // With carrier
                null,  // Price from
                null,  // Price to
                0,     // Price range price
                null,  // Weight from
                null,  // Weight to
                0,     // Weight range price
                0,     // Currency converter multiplier
                0,      // Ranges found
            ],

            // Test with carrier without ranges
            [
                true,  // With carrier
                null,  // Price from
                null,  // Price to
                0,     // Price range price
                null,  // Weight from
                null,  // Weight to
                0,     // Weight range price
                0,     // Currency converter multiplier
                0,      // Ranges found
            ],

            // Test with matching price
            [
                true,  // With carrier
                500,   // Price from
                1200,  // Price to
                700,   // Price range price
                null,  // Weight from
                null,  // Weight to
                0,     // Weight range price
                1,     // Currency converter multiplier
                1,      // Ranges found
            ],

            // Test without matching price
            [
                true,  // With carrier
                500,   // Price from
                600,   // Price to
                700,   // Price range price
                null,  // Weight from
                null,  // Weight to
                0,     // Weight range price
                1,     // Currency converter multiplier
                0,      // Ranges found
            ],

            // test with matching weight
            [
                true,  // With carrier
                null,  // Price from
                null,  // Price to
                0,     // Price range price
                800,   // Weight from
                1200,  // Weight to
                200,   // Weight range price
                1,     // Currency converter multiplier
                1,      // Ranges found
            ],

            // test without matching weight
            [
                true,  // With carrier
                null,  // Price from
                null,  // Price to
                0,     // Price range price
                800,   // Weight from
                900,   // Weight to
                200,   // Weight range price
                1,     // Currency converter multiplier
                0,      // Ranges found
            ],

            // test with different currencies matching
            [
                true,  // With carrier
                300,   // Price from
                600,   // Price to
                500,   // Price range price
                null,  // Weight from
                null,  // Weight to
                0,     // Weight range price
                2,     // Currency converter multiplier
                1,      // Ranges found
            ],

            // test with different currencies not matching
            [
                true,  // With carrier
                510,   // Price from
                600,   // Price to
                500,   // Price range price
                null,  // Weight from
                null,  // Weight to
                0,     // Weight range price
                2,     // Currency converter multiplier
                0,      // Ranges found
            ],

            // test with both pricing and weight matching
            [
                true,  // With carrier
                500,   // Price from
                600,   // Price to
                700,   // Price range price
                800,   // Weight from
                1200,  // Weight to
                200,   // Weight range price
                1,     // Currency converter multiplier
                1,      // Ranges found
            ],
        ];
    }

    /**
     * Get functional carrier
     */
    private function getBuiltCarrierRepository(
        $withCarrier,
        $priceFrom = null,
        $priceTo = null,
        $priceRangePrice = 0,
        $weightFrom = null,
        $weightTo = null,
        $weightRangePrice = 0
    ) {
        $carriers = [];
        $carrier = $this->getCarrier();

        if ($withCarrier) {
            $shippingRanges = [];
            $currency = $this->getCurrency();

            if ($priceFrom || $priceTo) {
                $priceShippingRange = $this->getShippingRange();
                $priceShippingRange
                    ->getFromPrice()
                    ->willReturn(Money::create(
                        $priceFrom,
                        $currency
                    ));
                $priceShippingRange
                    ->getToPrice()
                    ->willReturn(Money::create(
                        $priceTo,
                        $currency
                    ));
                $priceShippingRange
                    ->getPrice()
                    ->willReturn(Money::create(
                        $priceRangePrice,
                        $currency
                    ));
                $priceShippingRange
                    ->getType()
                    ->willReturn(ElcodiShippingRangeTypes::TYPE_PRICE);
                $priceShippingRange
                    ->getName()
                    ->willReturn('price-shipping-range-name');
                $priceShippingRange
                    ->getId()
                    ->willReturn('price-shipping-range-id');
                $priceShippingRange
                    ->getToZone()
                    ->willReturn(
                        $this
                            ->prophesize('Elcodi\Component\Zone\Entity\Interfaces\ZoneInterface')
                            ->reveal()
                    );
                $priceShippingRange
                    ->getCarrier()
                    ->willReturn($carrier);

                $shippingRanges[] = $priceShippingRange->reveal();
            }

            if ($weightFrom || $weightTo) {
                $weightShippingRange = $this->getShippingRange();
                $weightShippingRange
                    ->getFromWeight()
                    ->willReturn($weightFrom);
                $weightShippingRange
                    ->getToWeight()
                    ->willReturn($weightTo);
                $weightShippingRange
                    ->getPrice()
                    ->willReturn(Money::create(
                        $weightRangePrice,
                        $currency
                    ));
                $weightShippingRange
                    ->getType()
                    ->willReturn(ElcodiShippingRangeTypes::TYPE_WEIGHT);
                $weightShippingRange
                    ->getName()
                    ->willReturn('weight-shipping-range-name');
                $weightShippingRange
                    ->getId()
                    ->willReturn('weight-shipping-range-id');
                $weightShippingRange
                    ->getToZone()
                    ->willReturn(
                        $this
                            ->prophesize('Elcodi\Component\Zone\Entity\Interfaces\ZoneInterface')
                            ->reveal()
                    );
                $weightShippingRange
                    ->getCarrier()
                    ->willReturn($carrier);
                $shippingRanges[] = $weightShippingRange->reveal();
            }

            $carrier
                ->getRanges()
                ->willReturn(new ArrayCollection($shippingRanges));

            $carriers = [$carrier];
        }

        $carrierRepository = $this->getCarrierRepository();
        $carrierRepository
            ->findBy(Argument::type('array'))
            ->willReturn($carriers);

        return $carrierRepository;
    }

    /**
     * Get carrier repository prophecy object
     *
     * @return CarrierRepository Carrier repository
     */
    private function getCarrierRepository()
    {
        return $this->prophesize('Elcodi\Plugin\CustomShippingBundle\Repository\CarrierRepository');
    }

    /**
     * Get currency converter prophecy object
     *
     * @param float $multiplier Multiplier
     *
     * @return CurrencyConverter Currency converter
     */
    private function getCurrencyConverter($multiplier)
    {
        $currencyConverter = $this->prophesize('Elcodi\Component\Currency\Services\CurrencyConverter');
        $testObject = $this;

        $currencyConverter
            ->convertMoney(Argument::any(), Argument::any())
            ->will(function ($args) use ($multiplier, $testObject) {
                return Money::create(
                    $args[0]->getAmount() * $multiplier,
                    $testObject->getCurrency()
                );
            });

        return $currencyConverter;
    }

    /**
     * Get zone matcher prophecy object
     *
     * @return ZoneMatcher Cone matcher
     */
    private function getZoneMatcher($match = true)
    {
        $zoneMatcher = $this->prophesize('Elcodi\Component\Zone\Services\ZoneMatcher');

        $zoneMatcher
            ->isAddressContainedInZone(Argument::any(), Argument::any())
            ->willReturn($match);

        return $zoneMatcher;
    }

    /**
     * Get cart prophecy object
     *
     * Cart properties
     *
     * * 10.00 Eur
     * * 10 Kg
     *
     * @return CartInterface Cart
     */
    private function getCart()
    {
        $cart = $this->prophesize('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');

        $cart
            ->getPurchasableAmount()
            ->willReturn(Money::create(
                1000,
                $this->getCurrency()
            ));

        $cart
            ->getWeight()
            ->willReturn(1000);

        $cart
            ->getDeliveryAddress()
            ->willReturn(
                $this
                    ->prophesize('Elcodi\Component\Geo\Entity\Interfaces\AddressInterface')
                    ->reveal()
            );

        return $cart;
    }

    /**
     * Get cart object
     *
     * Cart properties
     *
     * * 10.00 Eur
     * * 10 Kg
     *
     * @return CartInterface Cart
     */
    private function getRevealedCart()
    {
        return $this
            ->getCart()
            ->reveal();
    }

    /**
     * Get carrier prophecy object
     *
     * @return CarrierInterface Carrier
     */
    private function getCarrier()
    {
        $carrier = $this->prophesize('Elcodi\Plugin\CustomShippingBundle\Entity\Interfaces\CarrierInterface');

        $carrier
            ->getName()
            ->willReturn('test-carrier');

        return $carrier;
    }

    /**
     * Get shipping range prophecy object
     *
     * @return ShippingRangeInterface Shipping range
     */
    public function getShippingRange()
    {
        return $this->prophesize('Elcodi\Plugin\CustomShippingBundle\Entity\Interfaces\ShippingRangeInterface');
    }

    /**
     * Get currency
     *
     * @return Currency Currency
     */
    private function getCurrency()
    {
        $currency = new Currency();
        $currency
            ->setIso('EUR')
            ->setSymbol("€")
            ->getName("Euro");

        return $currency;
    }
}
