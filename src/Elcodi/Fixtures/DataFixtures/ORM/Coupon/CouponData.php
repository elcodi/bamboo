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

namespace Elcodi\Fixtures\DataFixtures\ORM\Coupon;

use DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Coupon\ElcodiCouponTypes;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Factory\CouponFactory;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Rule\Entity\Interfaces\RuleInterface;

/**
 * Class CouponData
 */
class CouponData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var CouponFactory     $couponFactory
         * @var CurrencyInterface $currencyDollar
         * @var CurrencyInterface $currencyEuro
         */
        $couponFactory = $this->getFactory('coupon');
        $currencyDollar = $this->getReference('currency-USD');
        $currencyEuro = $this->getReference('currency-EUR');

        /**
         * Coupon with 12% of discount
         *
         * Valid from now, no expiration time
         *
         * Customer only can redeem it 5 times in all life
         *
         * @var CouponInterface $couponPercent
         */
        $couponPercent = $couponFactory->create();
        $couponPercent
            ->setCode('percent')
            ->setName('12 percent discount')
            ->setType(ElcodiCouponTypes::TYPE_PERCENT)
            ->setDiscount(12)
            ->setCount(5)
            ->setEnabled(true);
        $manager->persist($couponPercent);
        $this->addReference('coupon-percent', $couponPercent);

        /**
         * Coupon with 5 euros of discount
         *
         * Valid from now, no expiration time
         *
         * Can be redeemed many times
         *
         * @var CouponInterface $couponAmountEuro
         */
        $couponAmountEuro = $couponFactory->create();
        $couponAmountEuro
            ->setCode('5euros')
            ->setName('5 euros discount')
            ->setType(ElcodiCouponTypes::TYPE_AMOUNT)
            ->setPrice(Money::create(500, $currencyEuro))
            ->setEnabled(true);
        $manager->persist($couponAmountEuro);
        $this->addReference('coupon-amount-euro', $couponAmountEuro);

        /**
         * Coupon with 5 euros of discount
         *
         * Valid from now, no expiration time
         *
         * Only 20 available
         *
         * @var CouponInterface $couponAmountDollar
         */
        $couponAmountDollar = $couponFactory->create();
        $couponAmountDollar
            ->setCode('10dollars')
            ->setName('10 dollars discount')
            ->setType(ElcodiCouponTypes::TYPE_AMOUNT)
            ->setPrice(Money::create(1000, $currencyDollar))
            ->setCount(20)
            ->setEnabled(true);
        $manager->persist($couponAmountDollar);
        $this->addReference('coupon-amount-dollar', $couponAmountDollar);

        /**
         * Automatic coupon applies 50% to big spenders
         *
         * Valid from now, no expiration time
         *
         * @var CouponInterface $couponBigSpenders
         */
        $couponBigSpenders = $couponFactory->create();

        /**
         * @var RuleInterface $ruleBigSpenders
         */
        $ruleBigSpenders = $this->getReference('rule-big-spender');

        $couponBigSpenders
            ->setCode('bigspender')
            ->setName('50% discount')
            ->setType(ElcodiCouponTypes::TYPE_PERCENT)
            ->setDiscount(50)
            ->setRule($ruleBigSpenders)
            ->setEnforcement(ElcodiCouponTypes::ENFORCEMENT_AUTOMATIC)
            ->setEnabled(true);
        $manager->persist($couponBigSpenders);
        $this->addReference('coupon-big-spender', $couponBigSpenders);

        $manager->flush();
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
            'Elcodi\Fixtures\DataFixtures\ORM\Currency\CurrencyData',
            'Elcodi\Fixtures\DataFixtures\ORM\Rule\RuleData',
            'Elcodi\Fixtures\DataFixtures\ORM\Store\StoreData',
        ];
    }
}
