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

namespace Elcodi\Store\CartCouponBundle\EventListener;

use Elcodi\Component\CartCoupon\Entity\Interfaces\CartCouponInterface;
use Elcodi\Component\CartCoupon\Event\CartCouponOnApplyEvent;
use Elcodi\Component\CartCoupon\Repository\CartCouponRepository;
use Elcodi\Component\Coupon\ElcodiCouponTypes;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Exception\CouponIncompatibleException;

/**
 * Class JustOneManualCouponEventListener
 *
 * @author Berny Cantos <be@rny.cc>
 */
class JustOneManualCouponEventListener
{
    /**
     * @var CartCouponRepository
     *
     * CartCoupon repository
     */
    protected $cartCouponRepository;

    /**
     * Constructor
     *
     * @param CartCouponRepository $cartCouponRepository CartCoupon Repository
     */
    public function __construct(CartCouponRepository $cartCouponRepository)
    {
        $this->cartCouponRepository = $cartCouponRepository;
    }

    /**
     * Avoid applying a manual coupon if another is being applied
     *
     * @param CartCouponOnApplyEvent $event
     *
     * @throws CouponIncompatibleException
     */
    public function assertJustOneManualCoupon(CartCouponOnApplyEvent $event)
    {
        if (!$this->isManual($event->getCoupon())) {
            return null;
        }

        /**
         * @var CartCouponInterface[] $cartCoupons
         */
        $cartCoupons = $this
            ->cartCouponRepository
            ->findBy([
                'cart' => $event->getCart(),
            ]);

        foreach ($cartCoupons as $cartCoupon) {
            if ($this->isManual($cartCoupon->getCoupon())) {
                throw new CouponIncompatibleException();
            }
        }
    }

    /**
     * Check if a coupon has manual enforcement
     *
     * @param CouponInterface $coupon Coupon
     *
     * @return bool
     */
    protected function isManual(CouponInterface $coupon)
    {
        return $coupon->getEnforcement() === ElcodiCouponTypes::ENFORCEMENT_MANUAL;
    }
}
