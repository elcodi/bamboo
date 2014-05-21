<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  * @version  */
 
namespace Store\StoreUserBundle\Controller;

use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class SecurityController
 */
class SecurityController extends Controller
{
    /**
     * Login page
     *
     * @return array
     *
     * @Route(
     *      path = "/login",
     *      name = "store_login"
     * )
     * @Template
     */
    public function loginAction()
    {
        $customer = $this
            ->get('elcodi.core.user.wrapper.customer_wrapper')
            ->getCustomer();

        if ($customer instanceof CustomerInterface) {

            $this->redirect('store_home');
        }

        return [];
    }

    /**
     * Register page
     *
     * @return array
     *
     * @Route(
     *      path = "/register",
     *      name = "store_register"
     * )
     * @Template
     */
    public function registerAction()
    {
        $customer = $this
            ->get('elcodi.core.user.wrapper.customer_wrapper')
            ->getCustomer();

        if ($customer instanceof CustomerInterface) {

            $this->redirect('store_home');
        }

        return [];
    }
}
 