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

namespace Elcodi\Admin\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;

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
     * @return array Result
     *
     * @Route(
     *      path = "",
     *      name = "admin_profile_view",
     *      methods = {"GET"}
     * )
     * @Template
     */
    public function viewAction()
    {
        return [];
    }
}
