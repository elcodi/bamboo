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

namespace Elcodi\Admin\CartBundle\Listener;

use Doctrine\Common\Persistence\ObjectRepository;

use Elcodi\Component\Cart\Repository\OrderRepository;
use Elcodi\Component\Menu\Event\MenuEvent;

/**
 * Class OrderCountInMenuListener
 *
 * @author Berny Cantos <be@rny.cc>
 */
class OrderCountInMenuListener
{
    /**
     * @var OrderRepository
     *
     * Order repository
     */
    protected $orderRepository;

    /**
     * Constructor
     *
     * @param ObjectRepository $orderRepository
     */
    public function __construct(ObjectRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Add a badge with pending orders number to the order menu
     *
     * @param MenuEvent $event
     */
    public function onMenuPostLoad(MenuEvent $event)
    {
        $pendingOrders = $this
            ->orderRepository
            ->getNotShippedOrders();

        $event->addFilter(function ($item) use ($pendingOrders) {

            if ('admin_order_list' == $item['url']) {
                $item['badge'] = count($pendingOrders);
            }

            return $item;
        });
    }
}
