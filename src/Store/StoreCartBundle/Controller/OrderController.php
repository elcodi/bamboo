<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * This distribution is just a basic e-commerce implementation based on
 * Elcodi project.
 *
 * Feel free to edit it, and make your own
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Store\StoreCartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
     * @param integer $orderId Order id
     * @param boolean $thanks  Thanks
     *
     * @return array
     *
     * @Route(
     *      path = "/{orderId}",
     *      name = "store_order_view",
     *      requirements = {
     *          "orderId": "\d+"
     *      },
     *      defaults = {
     *          "thanks": false
     *      }
     * )
     * @Route(
     *      path = "/{orderId}/thanks",
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
     * @throws EntityNotFoundException
     */
    public function viewAction($orderId, $thanks)
    {
        $order = $this
            ->get('elcodi.repository.order')
            ->find($orderId);

        if (!($order instanceof OrderInterface)) {

            throw new EntityNotFoundException($this
                ->container
                ->getParameter('elcodi.core.cart.entity.order.class'));
        }

        return [
            'order'  => $order,
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
