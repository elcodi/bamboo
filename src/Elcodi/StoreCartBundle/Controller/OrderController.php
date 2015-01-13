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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\StoreCoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Order controllers
 *
 * @Route(
 *      path = "/order",
 * )
 */
class OrderController extends Controller
{
    use TemplateRenderTrait;

    /**
     * Order view
     *
     * @param OrderInterface $order  Order id
     * @param boolean        $thanks Thanks
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/{id}",
     *      name = "store_order_view",
     *      requirements = {
     *          "orderId": "\d+"
     *      },
     *      defaults = {
     *          "thanks": false
     *      },
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/{id}/thanks",
     *      name = "store_order_thanks",
     *      requirements = {
     *          "orderId": "\d+"
     *      },
     *      defaults = {
     *          "thanks": true
     *      },
     *      methods = {"GET"}
     * )
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

        return $this->renderTemplate(
            'Pages:order-view.html.twig',
            [
                'order'        => $order,
                'orderCoupons' => $orderCoupons,
                'thanks'       => $thanks,
            ]
        );
    }

    /**
     * Order list
     *
     * @return Response Response
     *
     * @Route(
     *      path = "s",
     *      name = "store_order_list",
     *      methods = {"GET"}
     * )
     */
    public function listAction()
    {
        $orders = $this
            ->get('elcodi.customer_wrapper')
            ->loadCustomer()
            ->getOrders();

        return $this->renderTemplate(
            'Pages:order-list.html.twig',
            [
                'orders' => $orders,
            ]
        );
    }
}
