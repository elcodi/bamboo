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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class CheckoutController
 *
 * @Route(
 *      path = "/checkout",
 * )
 */
class CheckoutController extends Controller
{
    /**
     * Checkout payment step
     *
     * @return array
     *
     * @Route(
     *      path = "/payment",
     *      name = "store_checkout_payment"
     * )
     * @Method("GET")
     * @Template
     */
    public function paymentAction()
    {
        return [];
    }

    /**
     * Checkout payment step
     *
     * @param int $orderId Order id
     *
     * @return array
     *
     * @Route(
     *      path = "/order/{orderId}",
     *      name = "store_checkout_thanks"
     * )
     * @Method("GET")
     * @Template
     */
    public function orderAction($orderId)
    {
        return [];
    }
}
