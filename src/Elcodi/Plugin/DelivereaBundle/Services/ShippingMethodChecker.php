<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Plugin\DelivereaBundle\Services;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\EventDispatcher\CartEventDispatcher;
use Elcodi\Component\Shipping\Entity\ShippingMethod;
use Elcodi\Component\Shipping\Wrapper\ShippingWrapper;
use Elcodi\Plugin\DelivereaBundle\DelivereaShippingMethods;

/**
 * Class ShippingMethodChecker
 */
class ShippingMethodChecker
{
    /**
     * @var ShippingWrapper
     *
     * The shipping wrapper
     */
    private $shippingWrapper;

    /**
     * @var CartEventDispatcher
     *
     * The cart event dispatcher.
     */
    private $cartEventDispatcher;

    /**
     * Builds a new class.
     *
     * @param ShippingWrapper     $shippingWrapper     The shipping wrapper.
     * @param CartEventDispatcher $cartEventDispatcher The cart event dispatcher.
     */
    public function __construct(
        ShippingWrapper $shippingWrapper,
        CartEventDispatcher $cartEventDispatcher
    ) {
        $this->shippingWrapper = $shippingWrapper;
        $this->cartEventDispatcher = $cartEventDispatcher;
    }

    /**
     * Checks if an order has a deliverea shipping.
     *
     * @param OrderInterface $order The order to check.
     *
     * @return bool
     */
    public function orderHasDelivereaShipping(OrderInterface $order)
    {
        $shippingMethod = $order->getShippingMethod();

        return (
            $shippingMethod instanceof ShippingMethod &&
            DelivereaShippingMethods::DELIVEREA == $shippingMethod->getId()
        );
    }
}
