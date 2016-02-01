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

namespace Elcodi\Admin\CartBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Class Controller for Customer Orders
 *
 * @Route(
 *      path = "/customer-order",
 * )
 */
class CustomerOrderController extends AbstractAdminController
{
    /**
     * List elements of orders for a customer
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsibility
     *
     * @param CustomerInterface $customer         Customer
     * @param integer           $page             Page
     * @param integer           $limit            Limit of items per page
     * @param string            $orderByField     Field to order by
     * @param string            $orderByDirection Direction to order by
     *
     * @return array Result
     *
     * @Route(
     *      path =
     *      "s/{customerId}/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_customer_order_list",
     *      requirements = {
     *          "page" = "\d*",
     *          "limit" = "\d*",
     *      },
     *      defaults = {
     *          "page" = "1",
     *          "limit" = "50",
     *          "orderByField" = "id",
     *          "orderByDirection" = "DESC",
     *      },
     * )
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.customer.class",
     *      name = "customer",
     *      mapping = {
     *          "id" = "~customerId~"
     *      }
     * )
     * @Template
     * @Method({"GET"})
     */
    public function listAction(
        CustomerInterface $customer,
        $page,
        $limit,
        $orderByField,
        $orderByDirection
    ) {
        return [
            'customer'         => $customer,
            'page'             => $page,
            'limit'            => $limit,
            'orderByField'     => $orderByField,
            'orderByDirection' => $orderByDirection,
        ];
    }
}
