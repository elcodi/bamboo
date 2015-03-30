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

namespace Elcodi\Admin\UserBundle\Controller\Stats;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractStatsController;

/**
 * Class CustomerStatsController
 *
 * @Route(
 *      path = "/customers/stats"
 * )
 */
class CustomerStatsController extends AbstractStatsController
{
    /**
     * Get count of all elements
     *
     * @return mixed
     *
     * @Route(
     *      path = "/total",
     *      name = "admin_customer_stats_total",
     *      methods = {"GET"}
     * )
     * @Template("AdminCoreBundle:Stats:total.html.twig")
     */
    public function totalStatsAction()
    {
        return [
            'total' => $this->getTotalStats('elcodi.core.user.entity.customer.class'),
        ];
    }

    /**
     * Get last month elements count
     *
     * @return mixed
     *
     * @Route(
     *      path = "/monthly",
     *      name = "admin_customer_stats_monthly",
     *      methods = {"GET"}
     * )
     * @Template("AdminCoreBundle:Stats:monthly.html.twig")
     */
    public function monthlyStatsAction()
    {
        return [
            'total' => $this->getMonthlyStats('elcodi.core.user.entity.customer.class'),
        ];
    }

    /**
     * Get today elements count
     *
     * @return mixed
     *
     * @Route(
     *      path = "/daily",
     *      name = "admin_customer_stats_daily",
     *      methods = {"GET"}
     * )
     * @Template("AdminCoreBundle:Stats:daily.html.twig")
     */
    public function dailyStatsAction()
    {
        return [
            'total' => $this->getDailyStats('elcodi.core.user.entity.customer.class'),
        ];
    }
}
