<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * This distribution is just a basic e-commerce implementation based on
 * Elcodi project.
 *
 * Feel free to edit it, and make your own
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Store\StoreProductBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;

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
         * @var CurrencyInterface $currencyDollar
         */
        $currencyDollar = $this
            ->container
            ->get('elcodi.factory.currency')->create();

        $currencyDollar
            ->setSymbol('$')
            ->setIso('USD');

        $manager->persist($currencyDollar);
        $this->setReference('currency-dollar', $currencyDollar);

        /**
         * @var CurrencyInterface $currencyEuro
         */
        $currencyEuro = $this
            ->container
            ->get('elcodi.factory.currency')->create();

        $currencyEuro
            ->setSymbol('€')
            ->setIso('EUR');

        $manager->persist($currencyEuro);
        $this->setReference('currency-euro', $currencyEuro);

        /**
         * @var CurrencyInterface $currencyPound
         */
        $currencyPound = $this
            ->container
            ->get('elcodi.factory.currency')->create();

        $currencyPound
            ->setSymbol('£')
            ->setIso('GBP');

        $manager->persist($currencyPound);
        $this->setReference('currency-pound', $currencyPound);

        $manager->flush();
    }

    /**
     * Order for given fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 0;
    }
}
