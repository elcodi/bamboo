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

namespace Elcodi\Plugin\CustomShippingBundle\Tests\UnitTest\EventListener;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;
use Prophecy\Argument;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Currency\Entity\Currency;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Shipping\Entity\ShippingMethod;
use Elcodi\Component\Shipping\Event\ShippingCollectionEvent;
use Elcodi\Component\Zone\Services\ZoneMatcher;
use Elcodi\Plugin\CustomShippingBundle\ElcodiShippingRangeTypes;
use Elcodi\Plugin\CustomShippingBundle\Entity\Interfaces\CarrierInterface;
use Elcodi\Plugin\CustomShippingBundle\Entity\Interfaces\ShippingRangeInterface;
use Elcodi\Plugin\CustomShippingBundle\EventListener\ShippingCollectEventListener;
use Elcodi\Plugin\CustomShippingBundle\Repository\CarrierRepository;

/**
 * Class ShippingCollectEventListenerTest
 *
 * * Test with no carriers
 * * Test with carrier without ranges
 * * Test with matching price
 * * Test with no matching price
 * * Test with matching weight
 * * Test with no matching weight
 * * Test with different currencies matching
 * * Test with different currencies without matching
 * * Test with matching price and weight
 */
class ShippingCollectEventListenerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test with no carriers
     */
    public function testWithNoCarriers()
    {
        $carrierRepository = $this->getBuiltCarrierRepository(false);

        $event = $this->getEvent();
        $event
            ->addShippingMethod(Argument::any())
            ->shouldNotBeCalled();
        $event
            ->getCart()
            ->willReturn($this->getCart()->reveal());

        $shippingCollectEventListener = new ShippingCollectEventListener(
            $carrierRepository->reveal(),
            $this->getCurrencyConverter(0)->reveal(),
            $this->getZoneMatcher()->reveal()
        );
        $shippingCollectEventListener->addCustomShippingMethods($event->reveal());
    }

    /**
     * Test with carrier without ranges
     */
    public function testWithCarrierWithoutRanges()
    {
        $carrierRepository = $this->getBuiltCarrierRepository(true);

        $event = $this->getEvent();
        $event
            ->addShippingMethod(Argument::any())
            ->shouldNotBeCalled();
        $event
            ->getCart()
            ->willReturn($this->getCart()->reveal());

        $shippingCollectEventListener = new ShippingCollectEventListener(
            $carrierRepository->reveal(),
            $this->getCurrencyConverter(0)->reveal(),
            $this->getZoneMatcher()->reveal()
        );
        $shippingCollectEventListener->addCustomShippingMethods($event->reveal());
    }

    /**
     * Test with matching price
     */
    public function testWithMatchingPrice()
    {
        $carrierRepository = $this->getBuiltCarrierRepository(
            true,
            500,
            1200,
            700
        );

        $event = $this->getEvent();
        $event
            ->addShippingMethod(\Prophecy\Argument::exact(
                new ShippingMethod(
                    'custom-shipping-method-price-shipping-range-id',
                    'test-carrier',
                    'price-shipping-range-name',
                    '',
                    Money::create(
                        700,
                        $this->getCurrency()
                    )
                )
            ))
            ->shouldBeCalledTimes(1);

        $event
            ->getCart()
            ->willReturn(
                $this
                    ->getCart()
                    ->reveal()
            );

        $shippingCollectEventListener = new ShippingCollectEventListener(
            $carrierRepository->reveal(),
            $this->getCurrencyConverter(1)->reveal(),
            $this->getZoneMatcher()->reveal()
        );
        $shippingCollectEventListener->addCustomShippingMethods($event->reveal());
    }

    /**
     * Test without matching price
     */
    public function testWithoutMatchingPrice()
    {
        $carrierRepository = $this->getBuiltCarrierRepository(
            true,
            500,
            600,
            700
        );

        $event = $this->getEvent();
        $event
            ->addShippingMethod(Argument::any())
            ->shouldNotBeCalled();

        $event
            ->getCart()
            ->willReturn(
                $this
                    ->getCart()
                    ->reveal()
            );

        $shippingCollectEventListener = new ShippingCollectEventListener(
            $carrierRepository->reveal(),
            $this->getCurrencyConverter(1)->reveal(),
            $this->getZoneMatcher()->reveal()
        );
        $shippingCollectEventListener->addCustomShippingMethods($event->reveal());
    }

    /**
     * Test with matching weight
     */
    public function testWithMatchingWeight()
    {
        $carrierRepository = $this->getBuiltCarrierRepository(
            true,
            null,
            null,
            null,
            800,
            1200,
            200
        );

        $event = $this->getEvent();
        $event
            ->addShippingMethod(\Prophecy\Argument::exact(
                new ShippingMethod(
                    'custom-shipping-method-weight-shipping-range-id',
                    'test-carrier',
                    'weight-shipping-range-name',
                    '',
                    Money::create(
                        200,
                        $this->getCurrency()
                    )
                )
            ))
            ->shouldBeCalledTimes(1);

        $event
            ->getCart()
            ->willReturn(
                $this
                    ->getCart()
                    ->reveal()
            );

        $shippingCollectEventListener = new ShippingCollectEventListener(
            $carrierRepository->reveal(),
            $this->getCurrencyConverter(1)->reveal(),
            $this->getZoneMatcher()->reveal()
        );
        $shippingCollectEventListener->addCustomShippingMethods($event->reveal());
    }

    /**
     * Test without matching weight
     */
    public function testWithoutMatchingWeight()
    {
        $carrierRepository = $this->getBuiltCarrierRepository(
            true,
            null,
            null,
            null,
            800,
            900,
            200
        );

        $event = $this->getEvent();
        $event
            ->addShippingMethod(Argument::any())
            ->shouldNotBeCalled();

        $event
            ->getCart()
            ->willReturn(
                $this
                    ->getCart()
                    ->reveal()
            );

        $shippingCollectEventListener = new ShippingCollectEventListener(
            $carrierRepository->reveal(),
            $this->getCurrencyConverter(1)->reveal(),
            $this->getZoneMatcher()->reveal()
        );
        $shippingCollectEventListener->addCustomShippingMethods($event->reveal());
    }

    /**
     * Test with different currencies matching
     */
    public function testWithDifferentCurrenciesMatching()
    {
        $carrierRepository = $this->getBuiltCarrierRepository(
            true,
            300,
            600,
            500
        );

        $event = $this->getEvent();
        $event
            ->addShippingMethod(\Prophecy\Argument::exact(
                new ShippingMethod(
                    'custom-shipping-method-price-shipping-range-id',
                    'test-carrier',
                    'price-shipping-range-name',
                    '',
                    Money::create(
                        500,
                        $this->getCurrency()
                    )
                )
            ))
            ->shouldBeCalledTimes(1);

        $event
            ->getCart()
            ->willReturn(
                $this
                    ->getCart()
                    ->reveal()
            );

        $shippingCollectEventListener = new ShippingCollectEventListener(
            $carrierRepository->reveal(),
            $this->getCurrencyConverter(2)->reveal(),
            $this->getZoneMatcher()->reveal()
        );
        $shippingCollectEventListener->addCustomShippingMethods($event->reveal());
    }

    /**
     * Test with different currencies without matching
     */
    public function testWithDifferentCurrenciesWithoutMatching()
    {
        $carrierRepository = $this->getBuiltCarrierRepository(
            true,
            510,
            600,
            700
        );

        $event = $this->getEvent();
        $event
            ->addShippingMethod(Argument::any())
            ->shouldNotBeCalled();

        $event
            ->getCart()
            ->willReturn(
                $this
                    ->getCart()
                    ->reveal()
            );

        $shippingCollectEventListener = new ShippingCollectEventListener(
            $carrierRepository->reveal(),
            $this->getCurrencyConverter(2)->reveal(),
            $this->getZoneMatcher()->reveal()
        );
        $shippingCollectEventListener->addCustomShippingMethods($event->reveal());
    }

    /**
     * Test with matching price and weight
     */
    public function testWithMatchingPriceAndWeight()
    {
        $carrierRepository = $this->getBuiltCarrierRepository(
            true,
            500,
            600,
            700,
            800,
            1200,
            200
        );

        $event = $this->getEvent();
        $event
            ->addShippingMethod(Argument::any())
            ->shouldBeCalledTimes(1);

        $event
            ->getCart()
            ->willReturn(
                $this
                    ->getCart()
                    ->reveal()
            );

        $shippingCollectEventListener = new ShippingCollectEventListener(
            $carrierRepository->reveal(),
            $this->getCurrencyConverter(1)->reveal(),
            $this->getZoneMatcher()->reveal()
        );
        $shippingCollectEventListener->addCustomShippingMethods($event->reveal());
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
     * Get event prophecy object
     *
     * @return ShippingCollectionEvent Event
     */
    private function getEvent()
    {
        return $this->prophesize('Elcodi\Component\Shipping\Event\ShippingCollectionEvent');
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
            ->getProductAmount()
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
