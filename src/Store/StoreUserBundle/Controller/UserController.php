<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  * @version
 */

namespace Store\StoreUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;

/**
 * Class UserController
 */
class UserController extends Controller
{
    /**
     * Customer bar in top position
     *
     * @return array
     *
     * @Route(
     *      path = "/user/top",
     *      name = "store_user_top"
     * )
     * @Template
     */
    public function topAction()
    {
        $customer = $this
            ->get('elcodi.core.user.wrapper.customer_wrapper')
            ->getCustomer();

        $isCustomer = $customer instanceof CustomerInterface;

        return [
            'customer'  =>  $customer,
            'isCustomer' => $isCustomer
        ];
    }
}
 