<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Admin\ConfigurationBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;

/**
 * Class Controller for payment configuration
 *
 * @Route(
 *      path = "/payment",
 * )
 */
class PaymentController extends AbstractAdminController
{
    /**
     * List payment configuration values
     *
     * @return array Result
     *
     * @Route(
     *      path = "",
     *      name = "admin_payment_configuration_list"
     * )
     * @Template
     * @Method({"GET"})
     */
    public function listAction()
    {
        return [];
    }
}
