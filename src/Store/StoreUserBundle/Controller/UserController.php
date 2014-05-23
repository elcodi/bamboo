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
 * @author ##author_placeholder
 * @version ##version_placeholder##
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

        $isLogged = $this->get('security.context')->isGranted('ROLE_CUSTOMER');

        return [
            'customer' => $customer,
            'isLogged' => $isLogged
        ];
    }
}
