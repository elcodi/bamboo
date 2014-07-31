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

namespace Elcodi\AdminUserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Elcodi\AdminCoreBundle\Controller\Abstracts\AbstractAdminController;

/**
 * Class ProfileController
 *
 * @Route(
 *      path = "/profile",
 * )
 */
class ProfileController extends AbstractAdminController
{
    /**
     * View the connected user profile
     *
     * @param Request $request Request
     *
     * @return array Result
     *
     * @Route(
     *      path = "",
     *      name = "admin_profile_view"
     * )
     * @Template
     * @Method({"GET"})
     */
    public function viewAction(Request $request)
    {
        return [];
    }
}
