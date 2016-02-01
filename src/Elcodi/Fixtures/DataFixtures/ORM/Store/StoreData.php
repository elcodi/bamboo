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

namespace Elcodi\Fixtures\DataFixtures\ORM\Store;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Bundle\MediaBundle\DataFixtures\ORM\Traits\ImageManagerTrait;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Store\Entity\Interfaces\StoreInterface;

/**
 * Class StoreData
 */
class StoreData extends AbstractFixture implements DependentFixtureInterface
{
    use ImageManagerTrait;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectDirector $storeDirector
         */
        $storeDirector = $this->getDirector('store');
        $address = $this->getReference('address-home');
        $language = $this->getReference('language-en');
        $currency = $this->getReference('currency-USD');

        /**
         * @var StoreInterface $store
         */
        $store = $storeDirector
            ->create()
            ->setName('Bamboo Store')
            ->setLeitmotiv('A store powered by Elcodi')
            ->setEmail('email@email.com')
            ->setIsCompany(true)
            ->setCif('B-12345678')
            ->setTracker('123456')
            ->setTemplate('2f1614601b2241b90c05cb67bc08f1ab7ba52af0')
            ->setUseStock(true)
            ->setAddress($address)
            ->setDefaultLanguage($language)
            ->setDefaultCurrency($currency);

        $storeDirector->save($store);
        $this->setReference('store', $store);
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
            'Elcodi\Fixtures\DataFixtures\ORM\Language\LanguageData',
            'Elcodi\Fixtures\DataFixtures\ORM\Currency\CurrencyData',
            'Elcodi\Fixtures\DataFixtures\ORM\Address\AddressData',
        ];
    }
}
