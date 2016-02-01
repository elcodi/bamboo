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

namespace Elcodi\Plugin\CustomShippingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslatorInterface;
use Elcodi\Component\Zone\Entity\Interfaces\ZoneInterface;
use Elcodi\Plugin\CustomShippingBundle\ElcodiShippingRangeTypes;

/**
 * Class CarrierData
 */
class CarrierData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectDirector            $carrierDirector
         * @var EntityTranslatorInterface $entityTranslator
         */
        $carrierDirector = $this->getDirector('carrier');
        $entityTranslator = $this->get('elcodi.entity_translator');

        $carrier = $carrierDirector
            ->create()
            ->setName('default')
            ->setTax($this->getReference('tax-vat-21'))
            ->setDescription('Default carrier')
            ->setEnabled(true);

        $this->setReference('carrier-default', $carrier);
        $carrierDirector->save($carrier);

        $entityTranslator->save($carrier, [
            'en' => [
                'name'        => 'Basic',
                'description' => 'Our basic delivery system',
            ],
            'es' => [
                'name'        => 'Básico',
                'description' => 'Nuestro sistema de entrega básico',
            ],
            'fr' => [
                'name'        => 'Minimale',
                'description' => 'Notre système de livraison basique',
            ],
            'ca' => [
                'name'        => 'Bàsic',
                'description' => 'El nostre sistema d\'entrega bàsic',
            ],
        ]);

        /**
         * @var CurrencyInterface $currencyEuro
         * @var ZoneInterface     $zoneSpain
         */
        $zoneSpain = $this->getReference('zone-spain');
        $currencyEuro = $this->getReference('currency-EUR');
        $shippingRangeDirector = $this->getDirector('shipping_range');

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
            'Elcodi\Fixtures\DataFixtures\ORM\Tax\TaxData',
            'Elcodi\Fixtures\DataFixtures\ORM\Zone\ZoneData',
            'Elcodi\Fixtures\DataFixtures\ORM\Currency\CurrencyData',
            'Elcodi\Fixtures\DataFixtures\ORM\Store\StoreData',
        ];
    }
}
