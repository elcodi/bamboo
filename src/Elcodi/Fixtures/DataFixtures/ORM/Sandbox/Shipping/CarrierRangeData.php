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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Fixtures\DataFixtures\ORM\Sandbox\Shipping;

use Doctrine\Common\Persistence\ObjectManager;
use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Shipping\ElcodiShippingRangeTypes;
use Elcodi\Component\Shipping\Entity\Interfaces\CarrierInterface;
use Elcodi\Component\Zone\Entity\Interfaces\ZoneInterface;

/**
 * Class CarrierRangeData
 */
class CarrierRangeData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var CurrencyInterface $currencyEuro
         * @var ZoneInterface     $zoneSpain
         * @var CarrierInterface $carrier
         */
        $zoneSpain = $this->getReference('zone-spain');
        $currencyEuro = $this->getReference('currency-EUR');
        $shippingRangeDirector = $this->getDirector('shipping_range');
        $carrier = $this->getReference('carrier-default');

        $shippingPriceRange1 = $shippingRangeDirector
            ->create()
            ->setType(ElcodiShippingRangeTypes::TYPE_PRICE)
            ->setCarrier($carrier)
            ->setName('From 0€ to 10€')
            ->setFromZone($zoneSpain)
            ->setToZone($zoneSpain)
            ->setFromPrice(Money::create(0, $currencyEuro))
            ->setToPrice(Money::create(1000, $currencyEuro))
            ->setPrice(Money::create(900, $currencyEuro))
            ->setEnabled(true);

        $shippingPriceRange2 = $shippingRangeDirector
            ->create()
            ->setType(ElcodiShippingRangeTypes::TYPE_PRICE)
            ->setCarrier($carrier)
            ->setName('From 10€ to 20€')
            ->setFromZone($zoneSpain)
            ->setToZone($zoneSpain)
            ->setFromPrice(Money::create(1000, $currencyEuro))
            ->setToPrice(Money::create(2000, $currencyEuro))
            ->setPrice(Money::create(500, $currencyEuro))
            ->setEnabled(true);

        $shippingPriceRange3 = $shippingRangeDirector
            ->create()
            ->setType(ElcodiShippingRangeTypes::TYPE_PRICE)
            ->setCarrier($carrier)
            ->setName('Free for up to 20€')
            ->setFromZone($zoneSpain)
            ->setToZone($zoneSpain)
            ->setFromPrice(Money::create(2000, $currencyEuro))
            ->setToPrice(Money::create(999999999, $currencyEuro))
            ->setPrice(Money::create(115, $currencyEuro))
            ->setEnabled(true);

        $shippingRangeDirector->save($shippingPriceRange1);
        $shippingRangeDirector->save($shippingPriceRange2);
        $shippingRangeDirector->save($shippingPriceRange3);
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'Elcodi\Fixtures\DataFixtures\ORM\Base\Shipping\CarriersData',
            'Elcodi\Fixtures\DataFixtures\ORM\Sandbox\Currency\CurrencyData',
            'Elcodi\Fixtures\DataFixtures\ORM\Base\Zone\ZoneData',
        ];
    }
}
