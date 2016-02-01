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

namespace Elcodi\Store\CartBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Store\CoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Order controllers
 *
 * @Security("has_role('ROLE_CUSTOMER')")
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
     * @param integer $id     Order id
     * @param boolean $thanks Thanks
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
     */
    public function viewAction($id, $thanks)
    {
        $order = $this
            ->get('elcodi.repository.order')
            ->findOneBy([
                'id'       => $id,
                'customer' => $this->getUser(),
            ]);

        if (!($order instanceof OrderInterface)) {
            throw $this->createNotFoundException('Order not found');
        }

        $orderCoupons = $this
            ->get('elcodi.repository.order_coupon')
            ->findOrderCouponsByOrder($order);

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
            ->get('elcodi.wrapper.customer')
            ->get()
            ->getOrders();

        return $this->renderTemplate(
            'Pages:order-list.html.twig',
            [
                'orders' => $orders,
            ]
        );
    }
}
