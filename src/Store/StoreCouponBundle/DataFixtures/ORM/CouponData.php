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

namespace Store\StoreCouponBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DateTime;

use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;
use Elcodi\CouponBundle\ElcodiCouponTypes;
use Elcodi\CouponBundle\Factory\CouponFactory;
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Entity\Money;

/**
 * Class CouponData
 */
class CouponData extends AbstractFixture implements OrderedFixtureInterface
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
        $couponFactory = $this->container->get('elcodi.core.coupon.factory.coupon');
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
     * Order for given fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}
