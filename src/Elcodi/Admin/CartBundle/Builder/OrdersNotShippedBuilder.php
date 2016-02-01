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

namespace Elcodi\Admin\CartBundle\Builder;

use Elcodi\Component\Cart\Repository\OrderRepository;
use Elcodi\Component\Menu\Builder\Abstracts\AbstractMenuBuilder;
use Elcodi\Component\Menu\Builder\Interfaces\MenuBuilderInterface;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface;
use Elcodi\Component\Menu\Factory\NodeFactory;

/**
 * Class OrdersNotShippedBuilder
 */
class OrdersNotShippedBuilder extends AbstractMenuBuilder implements MenuBuilderInterface
{
    /**
     * @var OrderRepository
     *
     * Order repository
     */
    protected $orderRepository;

    /**
     * Construct
     *
     * @param NodeFactory     $menuNodeFactory Menu node factory
     * @param OrderRepository $orderRepository Order repository
     */
    public function __construct(
        NodeFactory $menuNodeFactory,
        OrderRepository $orderRepository
    ) {
        parent::__construct($menuNodeFactory);

        $this->orderRepository = $orderRepository;
    }

    /**
     * Build the menu
     *
     * @param MenuInterface $menu Menu
     */
    public function build(MenuInterface $menu)
    {
        $menu
            ->findSubnodeByName('admin.order.plural')
            ->setWarnings($this->getNonShippedOrdersCount());
    }

    /**
     * Get all non-shipped orders count
     *
     * @return integer Non-shipped orders count
     */
    private function getNonShippedOrdersCount()
    {
        $notShippedOrders = $this
            ->orderRepository
            ->getOrdersToPrepare();

        return count($notShippedOrders);
    }
}
