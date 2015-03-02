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

namespace Elcodi\Admin\CurrencyBundle\DataFixtures\ORM\Currency;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Currency\Factory\CurrencyFactory;

/**
 * Class CurrencyEuroData
 */
class CurrencyEuroData extends AbstractFixture
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
        $currencyObjectManager = $this->get('elcodi.object_manager.currency');
        $currencyFactory = $this->get('elcodi.factory.currency');

        $currency = $currencyFactory
            ->create()
            ->setIso('EUR')
            ->setName('Euro')
            ->setSymbol('€')
            ->setEnabled(true);

        $currencyObjectManager->persist($currency);
        $currencyObjectManager->flush($currency);
    }
}
