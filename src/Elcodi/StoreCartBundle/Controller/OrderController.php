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

namespace Elcodi\StoreCartBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as AnnotationEntity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;

/**
 * Order controllers
 *
 * @Route(
 *      path = "/order",
 * )
 */
class OrderController extends Controller
{
    /**
     * Cart view
     *
     * @param OrderInterface $order  Order id
     * @param boolean        $thanks Thanks
     *
     * @return array
     *
     * @Route(
     *      path = "/{id}",
     *      name = "store_order_view",
     *      requirements = {
     *          "orderId": "\d+"
     *      },
     *      defaults = {
     *          "thanks": false
     *      }
     * )
     * @Route(
     *      path = "/{id}/thanks",
     *      name = "store_order_thanks",
     *      requirements = {
     *          "orderId": "\d+"
     *      },
     *      defaults = {
     *          "thanks": true
     *      }
     * )
     * @Template
     *
     * @AnnotationEntity(
     *      class = "elcodi.core.cart.entity.order.class",
     *      name = "order",
     *      mapping = {
     *          "id" = "~id~",
     *      }
     * )
     */
    public function viewAction(OrderInterface $order, $thanks)
    {
        $orderCoupons = $this
            ->get('elcodi.order_coupon_manager')
            ->getOrderCoupons($order);

        return [
            'order'  => $order,
            'orderCoupons'  =>  $orderCoupons,
            'thanks' => $thanks,
        ];
    }

    /**
     * Order list
     *
     * @return array
     *
     * @Route(
     *      path = "s",
     *      name = "store_order_list"
     * )
     * @Template
     */
    public function listAction()
    {
        $orders = $this
            ->get('elcodi.customer_wrapper')
            ->loadCustomer()
            ->getOrders();

        return [
            'orders' => $orders,
        ];
    }
}
