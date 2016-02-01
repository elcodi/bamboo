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

namespace Elcodi\Store\MetricBundle\EventListener;

use DateTime;

use Elcodi\Component\Cart\Event\OrderOnCreatedEvent;
use Elcodi\Component\Metric\Core\Services\MetricManager;
use Elcodi\Component\Metric\ElcodiMetricTypes;
use Elcodi\Component\Store\Entity\Interfaces\StoreInterface;

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
    private $metricManager;

    /**
     * @var StoreInterface
     *
     * Store
     */
    private $store;

    /**
     * Construct
     *
     * @param MetricManager  $metricManager Metric manager
     * @param StoreInterface $store         Store
     */
    public function __construct(
        MetricManager $metricManager,
        StoreInterface $store
    ) {
        $this->metricManager = $metricManager;
        $this->store = $store;
    }

    /**
     * Create metrics about the order creation
     *
     * @param OrderOnCreatedEvent $event Event
     */
    public function addMetric(OrderOnCreatedEvent $event)
    {
        $storeTracker = $this
            ->store
            ->getTracker();

        $this
            ->metricManager
            ->addEntry(
                $storeTracker,
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
                $storeTracker,
                'order_total',
                $orderAmount,
                ElcodiMetricTypes::TYPE_ACCUMULATED,
                new DateTime()
            );
    }
}
