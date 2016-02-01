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

namespace Elcodi\Admin\CurrencyBundle\DataFixtures\ORM\Currency;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;

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
         * @var ObjectDirector   $currencyDirector
         */
        $currencyDirector = $this->getDirector('currency');

        $currency = $currencyDirector
            ->create()
            ->setIso('EUR')
            ->setName('Euro')
            ->setSymbol('€')
            ->setEnabled(true);

        $currencyDirector->save($currency);
    }
}
