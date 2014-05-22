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

/**
 * Class PasswordController
 */
class PasswordController extends Controller
{
    /**
     * Remember password
     *
     * @return array
     *
     * @Route(
     *      path = "/password/remember",
     *      name = "store_password_remember"
     * )
     * @Template
     */
    public function rememberAction()
    {
        return [];
    }

    /**
     * Recover password
     *
     * @return array
     *
     * @Route(
     *      path = "/password/recover",
     *      name = "store_password_recover"
     * )
     * @Template
     */
    public function recoverAction()
    {
        return [];
    }
}
