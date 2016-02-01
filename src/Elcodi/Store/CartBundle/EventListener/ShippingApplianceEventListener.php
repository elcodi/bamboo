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

namespace Elcodi\Store\CartBundle\EventListener;

use Elcodi\Component\Cart\Event\CartOnLoadEvent;
use Elcodi\Component\Cart\EventDispatcher\CartEventDispatcher;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Shipping\Entity\ShippingMethod;
use Elcodi\Component\Shipping\Resolver\ShippingResolver;
use Elcodi\Component\Shipping\Wrapper\ShippingWrapper;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

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
    private $cartEventDispatcher;

    /**
     * @var ShippingWrapper
     *
     * Shipping Wrapper
     */
    private $shippingWrapper;

    /**
     * @var ShippingResolver
     *
     * Shipping method resolver
     */
    private $shippingResolver;

    /**
     * Construct
     *
     * @param CartEventDispatcher $cartEventDispatcher Cart Event Dispatcher
     * @param ShippingWrapper     $shippingWrapper     Shipping wrapper
     * @param ShippingResolver    $shippingResolver    Shipping Method Resolver
     */
    public function __construct(
        CartEventDispatcher $cartEventDispatcher,
        ShippingWrapper $shippingWrapper,
        ShippingResolver $shippingResolver
    ) {
        $this->cartEventDispatcher = $cartEventDispatcher;
        $this->shippingWrapper = $shippingWrapper;
        $this->shippingResolver = $shippingResolver;
    }

    /**
     * Remove shipping method from cart if this is not valid anymore
     *
     * @param CartOnLoadEvent $event Event
     *
     * @return $this Self object
     */
    public function removeInvalidShippingMethod(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();
        $cartShippingMethodId = $cart->getShippingMethod();

        if (null === $cartShippingMethodId) {
            return $this;
        }

        $shippingMethod = $this
            ->shippingWrapper
            ->getOneById($cart, $cartShippingMethodId);

        if (!($shippingMethod instanceof ShippingMethod)) {
            $cart->setShippingMethod(null);
            $this
                ->cartEventDispatcher
                ->dispatchCartLoadEvents($cart);

            $event->stopPropagation();
        }

        return $this;
    }

    /**
     * Loads cheapest shipping method if exists
     *
     * @param CartOnLoadEvent $event Event
     *
     * @return $this Self object
     */
    public function loadCheapestShippingMethod(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();
        $cartShippingMethodId = $cart->getShippingMethod();

        /**
         * We don't have the need to find the cheapest one if the real one is
         * already defined
         */
        if (null !== $cartShippingMethodId) {
            return $this;
        }

        /**
         * If the cart is not associated to any customer, just skip it
         */
        if (!($cart->getCustomer() instanceof CustomerInterface)) {
            return $this;
        }

        $address = ($cart->getDeliveryAddress() instanceof AddressInterface)
            ? $cart->getDeliveryAddress()
            : $cart
                ->getCustomer()
                ->getAddresses()
                ->first();

        /**
         * If the user does'nt have any address defined, we cannot approximate
         * anything
         */
        if (!($address instanceof AddressInterface)) {
            return $this;
        }

        $cart->setDeliveryAddress($address);

        $validShippingMethods = $this
            ->shippingWrapper
            ->get($cart);

        if (!empty($validShippingMethods)) {
            $cheapestShippingMethod = $this
                ->shippingResolver
                ->getCheapestShippingMethod($validShippingMethods);

            $cart->setCheapestShippingMethod($cheapestShippingMethod->getId());
        }

        return $this;
    }
}
