<?php

/**
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
 */

namespace Elcodi\Fixtures\DataFixtures\ORM;

use DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Coupon\ElcodiCouponTypes;
use Elcodi\Component\Coupon\Factory\CouponFactory;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\CouponBuComponent\Couponndle\Entity\Interfaces\CouponInterface;

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
        $couponFactory = $this->container->get('elcodi.factory.coupon');
        $currencyDollar = $this->getReference('currency-dollar');
        $currencyEuro = $this->getReference('currency-euro');

        /**
         * Coupon with 12% of discount
         *
         * Valid from now without expire time
         *
         * Customer only can redeem it 5 times in all life
         *
         * Only 100 available
         *
         * @var CouponInterface $couponPercent
         */
        $couponPercent = $couponFactory->create();
        $couponPercent
            ->setCode('percent')
            ->setName('10 percent discount')
            ->setType(ElcodiCouponTypes::TYPE_PERCENT)
            ->setDiscount(12)
            ->setCount(100)
            ->setEnabled(true)
            ->setValidFrom(new DateTime())
            ->setValidTo(new DateTime('next month'));
        $manager->persist($couponPercent);
        $this->addReference('coupon-percent', $couponPercent);

        /**
         * Coupon with 5 euros of discount
         *
         * Valid from now without expire time
         *
         * Customer only can redeem it n times in all life
         *
         * Only 20 available
         *
         * @var CouponInterface $couponAmountEuro
         */
        $couponAmountEuro = $couponFactory->create();
        $couponAmountEuro
            ->setCode('5euros')
            ->setName('5 euros discount')
            ->setType(ElcodiCouponTypes::TYPE_AMOUNT)
            ->setPrice(Money::create(500, $currencyEuro))
            ->setCount(20)
            ->setEnabled(true)
            ->setValidFrom(new DateTime());
        $manager->persist($couponAmountEuro);
        $this->addReference('coupon-amount-euro', $couponAmountEuro);

        /**
         * Coupon with 5 euros of discount
         *
         * Valid from now without expire time
         *
         * Customer only can redeem it n times in all life
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
            ->setEnabled(true)
            ->setValidFrom(new DateTime());
        $manager->persist($couponAmountDollar);
        $this->addReference('coupon-amount-dollar', $couponAmountDollar);

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
            'Elcodi\Fixtures\DataFixtures\ORM\CurrencyData',
        ];
    }
}
