<?php

/*
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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Admin\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;

/**
 * Class UserController
 *
 * @Route(
 *      path = "/user",
 * )
 */
class UserController extends AbstractAdminController
{
    /**
     * Nav for entity
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/nav",
     *      name = "admin_user_nav"
     * )
     * @Method({"GET"})
     * @Template
     */
    public function navAction()
    {
        return [];
    }
}
