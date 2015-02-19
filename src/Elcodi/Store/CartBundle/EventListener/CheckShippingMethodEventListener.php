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

namespace Elcodi\Store\CartBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Cart\Event\CartOnLoadEvent;
use Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface;
use Elcodi\Component\Shipping\Provider\ShippingRangeProvider;

/**
 * Class CheckShippingMethodEventListener
 */
class CheckShippingMethodEventListener
{
    /**
     * @var ObjectManager
     *
     * Cart Object Manager
     */
    protected $cartObjectManager;

    /**
     * @var ShippingRangeProvider
     *
     * Carrier provider
     */
    protected $shippingRangeProvider;

    /**
     * Construct
     *
     * @param ObjectManager         $cartObjectManager     Cart Object Manager
     * @param ShippingRangeProvider $shippingRangeProvider Carrier provider
     */
    public function __construct(
        ObjectManager $cartObjectManager,
        ShippingRangeProvider $shippingRangeProvider
    ) {
        $this->cartObjectManager = $cartObjectManager;
        $this->shippingRangeProvider = $shippingRangeProvider;
    }

    /**
     * Remove shipping range from cart if this is not valid anymore
     *
     * @param CartOnLoadEvent $event Event
     *
     * @return void
     */
    public function removeInvalidShippingRange(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();
        $shippingRange = $cart->getShippingRange();

        if (!($shippingRange instanceof ShippingRangeInterface)) {
            return;
        }

        $shippingRangeId = $shippingRange->getId();
        $validCarrierRanges = $this
            ->shippingRangeProvider
            ->getValidShippingRangesSatisfiedWithCart($cart);

        if (!isset($validCarrierRanges[$shippingRangeId])) {
            $cart->setShippingRange(null);
            $this
                ->cartObjectManager
                ->flush($cart);
        }

        return;
    }
}
