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

use Elcodi\Component\Cart\Event\CartOnLoadEvent;
use Elcodi\Component\Cart\EventDispatcher\CartEventDispatcher;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface;
use Elcodi\Component\Shipping\Provider\ShippingRangeProvider;
use Elcodi\Component\Shipping\Resolver\ShippingRangeResolver;

/**
 * Class ShippingApplianceEventListener
 */
class ShippingApplianceEventListener
{
    /**
     * @var CartEventDispatcher
     *
     * Cart Event Dispatcher
     */
    protected $cartEventDispatcher;

    /**
     * @var ShippingRangeProvider
     *
     * Carrier provider
     */
    protected $shippingRangeProvider;

    /**
     * @var ShippingRangeResolver
     *
     * Shipping Range Resolver
     */
    protected $shippingRangeResolver;

    /**
     * Construct
     *
     * @param CartEventDispatcher   $cartEventDispatcher   Cart Event Dispatcher
     * @param ShippingRangeProvider $shippingRangeProvider Carrier provider
     * @param ShippingRangeResolver $shippingRangeResolver Shipping range resolver
     */
    public function __construct(
        CartEventDispatcher $cartEventDispatcher,
        ShippingRangeProvider $shippingRangeProvider,
        ShippingRangeResolver $shippingRangeResolver
    ) {
        $this->cartEventDispatcher = $cartEventDispatcher;
        $this->shippingRangeProvider = $shippingRangeProvider;
        $this->shippingRangeResolver = $shippingRangeResolver;
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
                ->cartEventDispatcher
                ->dispatchCartLoadEvents($cart);

            $event->stopPropagation();
        }

        return;
    }

    /**
     * Loads cheapest shipping range if exists
     *
     * @param CartOnLoadEvent $event Event
     *
     * @return void
     */
    public function loadCheapestShippingRange(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();
        $shippingRange = $cart->getShippingRange();

        if (
            ($shippingRange instanceof ShippingRangeInterface) ||
            !($cart->getDeliveryAddress() instanceof AddressInterface)
        ) {
            return;
        }

        $validCarrierRanges = $this
            ->shippingRangeProvider
            ->getValidShippingRangesSatisfiedWithCart($cart);

        $cheapestCarrierRange = $this
            ->shippingRangeResolver
            ->getShippingRangeWithLowestPrice($validCarrierRanges);

        $cart->setCheapestShippingRange($cheapestCarrierRange);

        return;
    }
}
