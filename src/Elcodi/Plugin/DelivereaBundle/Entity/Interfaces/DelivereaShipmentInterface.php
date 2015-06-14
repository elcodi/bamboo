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

namespace Elcodi\Plugin\DelivereaBundle\Entity\Interfaces;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * Interface DelivereaShipmentInterface
 */
interface DelivereaShipmentInterface
    extends
    IdentifiableInterface,
    DateTimeInterface
{
    /**
     * Sets the order for this shipping.
     *
     * @param OrderInterface $order The order to set.
     *
     * @return $this Self object.
     */
    public function setOrder(OrderInterface $order);

    /**
     * Returns the deliverea shipping ref.
     *
     * @return string The deliverea shipping ref.
     */
    public function getDelivereaShippingRef();

    /**
     * Sets the deliverea shipping ref.
     *
     * @param string $delivereaShippingRef The deliverea shipping ref.
     *
     * @return $this Self object.
     */
    public function setDelivereaShippingRef($delivereaShippingRef);

    /**
     * Returns the deliverea shipping ref.
     *
     * @return string The client shipping ref.
     */
    public function getClientShippingRef();

    /**
     * Sets the deliverea shipping ref.
     *
     * @param string $clientShippingRef The client shipping ref.
     *
     * @return $this Self object.
     */
    public function setClientShippingRef($clientShippingRef);

    /**
     * Returns the carrier shipping ref.
     *
     * @return string The carrier shipping ref.
     */
    public function getCarrierShippingRef();

    /**
     * Sets the carrier shipping ref.
     *
     * @param string $carrierShippingRef The carrier shipping ref.
     *
     * @return $this Self object.
     */
    public function setCarrierShippingRef($carrierShippingRef);

    /**
     * Returns the carrier name.
     *
     * @return string The carrier name.
     */
    public function getCarrier();

    /**
     * Sets the carrier name.
     *
     * @param string $carrier The carrier name.
     *
     * @return $this Self object.
     */
    public function setCarrier($carrier);

    /**
     * Returns the service name.
     *
     * @return string The service name.
     */
    public function getService();

    /**
     * Sets the service name.
     *
     * @param string $service The service name.
     *
     * @return $this Self object.
     */
    public function setService($service);
}
