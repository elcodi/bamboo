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

namespace Elcodi\Plugin\CustomShippingBundle\EventListener;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Shipping\Entity\ShippingMethod;
use Elcodi\Component\Shipping\Event\ShippingCollectionEvent;
use Elcodi\Plugin\CustomShippingBundle\Provider\ShippingRangesProvider;

/**
 * Class ShippingCollectEventListener
 */
class ShippingCollectEventListener
{
    /**
     * @var Plugin
     *
     * Plugin
     */
    protected $plugin;

    /**
     * @var ShippingRangesProvider
     *
     * ShippingRanges provider
     */
    protected $shippingRangesProvider;

    /**
     * Construct method
     *
     * @param Plugin                 $plugin                 Plugin
     * @param ShippingRangesProvider $shippingRangesProvider ShippingRanges provider
     */
    public function __construct(
        Plugin $plugin,
        ShippingRangesProvider $shippingRangesProvider
    ) {
        $this->plugin = $plugin;
        $this->shippingRangesProvider = $shippingRangesProvider;
    }

    /**
     * Given a Cart, return a set of Valid ShippingRanges satisfied.
     *
     * @param ShippingCollectionEvent $event Event
     *
     * @return $this Self object
     */
    public function addCustomShippingMethods(ShippingCollectionEvent $event)
    {
        if (!$this
            ->plugin
            ->isEnabled()
        ) {
            return $this;
        }

        $cart = $event->getCart();
        $carrierRanges = $this
            ->shippingRangesProvider
            ->getAllShippingRangesSatisfiedWithCart($cart);

        foreach ($carrierRanges as $carrierRange) {
            $event
                ->addShippingMethod(new ShippingMethod(
                    'custom-shipping-method-' . $carrierRange->getId(),
                    $carrierRange->getCarrier()->getName(),
                    $carrierRange->getName(),
                    '',
                    $carrierRange->getPrice()
                ));
        }
    }
}
