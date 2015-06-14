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

namespace Elcodi\Plugin\DelivereaBundle\Entity;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Plugin\DelivereaBundle\Entity\Interfaces\DelivereaShipmentInterface;

/**
 * Class DelivereaShipment
 */
class DelivereaShipment implements DelivereaShipmentInterface
{
    use IdentifiableTrait, DateTimeTrait;

    /**
     * @var OrderInterface
     *
     * The order for this shipping
     */
    protected $order;

    /**
     * @var string
     *
     * The client shipping reference (Generated on shipment creation).
     */
    protected $clientShippingRef;

    /**
     * @var string
     *
     * The deliverea shipping reference (Deliverea identifier).
     */
    protected $delivereaShippingRef;

    /**
     * @var string
     *
     * The carrier shipping reference (Carrier identifier).
     */
    protected $carrierShippingRef;

    /**
     * @var string
     *
     * The carrier that's carrying out the shipment.
     */
    protected $carrier;

    /**
     * @var string
     *
     * The service name for this shipping (Economic, 24h, etc.)
     */
    protected $service;

    /**
     * Returns the order.
     *
     * @return OrderInterface The order for this shipping.
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Sets the order for this shipping.
     *
     * @param OrderInterface $order The order to set.
     *
     * @return $this Self object.
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Returns the deliverea shipping ref.
     *
     * @return string The deliverea shipping ref.
     */
    public function getDelivereaShippingRef()
    {
        return $this->delivereaShippingRef;
    }

    /**
     * Sets the deliverea shipping ref.
     *
     * @param string $delivereaShippingRef The deliverea shipping ref.
     *
     * @return $this Self object.
     */
    public function setDelivereaShippingRef($delivereaShippingRef)
    {
        $this->delivereaShippingRef = $delivereaShippingRef;

        return $this;
    }

    /**
     * Returns the deliverea shipping ref.
     *
     * @return string The client shipping ref.
     */
    public function getClientShippingRef()
    {
        return $this->clientShippingRef;
    }

    /**
     * Sets the deliverea shipping ref.
     *
     * @param string $clientShippingRef The client shipping ref.
     *
     * @return $this Self object.
     */
    public function setClientShippingRef($clientShippingRef)
    {
        $this->clientShippingRef = $clientShippingRef;

        return $this;
    }

    /**
     * Returns the carrier shipping ref.
     *
     * @return string The carrier shipping ref.
     */
    public function getCarrierShippingRef()
    {
        return $this->carrierShippingRef;
    }

    /**
     * Sets the carrier shipping ref.
     *
     * @param string $carrierShippingRef The carrier shipping ref.
     *
     * @return $this Self object.
     */
    public function setCarrierShippingRef($carrierShippingRef)
    {
        $this->carrierShippingRef = $carrierShippingRef;

        return $this;
    }

    /**
     * Returns the carrier name.
     *
     * @return string The carrier name.
     */
    public function getCarrier()
    {
        return $this->carrier;
    }

    /**
     * Sets the carrier name.
     *
     * @param string $carrier The carrier name.
     *
     * @return $this Self object.
     */
    public function setCarrier($carrier)
    {
        $this->carrier = $carrier;

        return $this;
    }

    /**
     * Returns the service name.
     *
     * @return string The service name.
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Sets the service name.
     *
     * @param string $service The service name.
     *
     * @return $this Self object.
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }
}
