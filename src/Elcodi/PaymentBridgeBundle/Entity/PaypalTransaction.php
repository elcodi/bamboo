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

namespace Elcodi\PaymentBridgeBundle\Entity;

use Elcodi\Component\Cart\Entity\Order;
use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;

/**
 * Class PaypalTransaction
 */
class PaypalTransaction
    implements
    IdentifiableInterface,
    DateTimeInterface
{
    use
        IdentifiableTrait,
        DateTimeTrait;

    /**
     * @var string
     */
    protected $transaction;

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param string $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }
}
