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

namespace Elcodi\Store\MetricBundle\EventListener;

use DateTime;

use Elcodi\Component\Cart\Event\OrderOnCreatedEvent;
use Elcodi\Component\Metric\Core\Services\MetricManager;
use Elcodi\Component\Metric\ElcodiMetricTypes;

/**
 * Class AddOrderCompletedMetricEventListener
 */
class AddOrderCompletedMetricEventListener
{
    /**
     * @var MetricManager
     *
     * Metric manager
     */
    protected $metricManager;

    /**
     * @var string
     *
     * Token
     */
    protected $token;

    /**
     * Construct
     *
     * @param MetricManager $metricManager Metric manager
     * @param string        $token         Token
     */
    public function __construct(MetricManager $metricManager, $token)
    {
        $this->metricManager = $metricManager;
        $this->token = $token;
    }

    /**
     * Create metrics about the order creation
     *
     * @param OrderOnCreatedEvent $event Event
     */
    public function addMetric(OrderOnCreatedEvent $event)
    {
        $this
            ->metricManager
            ->addEntry(
                $this->token,
                'order_nb',
                '0',
                ElcodiMetricTypes::TYPE_BEACON_ALL,
                new DateTime()
            );

        $orderAmount = $event
            ->getOrder()
            ->getAmount()
            ->getAmount();

        $this
            ->metricManager
            ->addEntry(
                $this->token,
                'order_total',
                $orderAmount,
                ElcodiMetricTypes::TYPE_ACCUMULATED,
                new DateTime()
            );
    }
}
