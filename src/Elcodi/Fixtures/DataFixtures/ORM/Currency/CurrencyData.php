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

namespace Elcodi\Fixtures\DataFixtures\ORM\Currency;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Currency\Factory\CurrencyFactory;

/**
 * Class CurrencyData
 */
class CurrencyData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var array           $currencies
         * @var ObjectManager   $currencyObjectManager
         * @var CurrencyFactory $currencyFactory
         */
        $currencies = $this->parseYaml(dirname(__FILE__) . '/currencies.yml');
        $currencyObjectManager = $this->get('elcodi.object_manager.currency');
        $currencyFactory = $this->get('elcodi.factory.currency');
        $currencyEntities = [];

        foreach ($currencies as $currencyIso => $currencyData) {
            $currency = $currencyFactory
                ->create()
                ->setIso($currencyIso)
                ->setName($currencyData['name'])
                ->setSymbol($currencyData['symbol'])
                ->setEnabled((boolean) $currencyData['enabled']);

            $this->setReference('currency-' . $currencyIso, $currency);
            $currencyObjectManager->persist($currency);
            $currencyEntities[] = $currency;
        }

        $currencyObjectManager->flush($currencyEntities);
    }
}
