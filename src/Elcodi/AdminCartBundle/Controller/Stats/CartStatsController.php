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

namespace Elcodi\AdminCartBundle\Controller\Stats;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\AdminCoreBundle\Controller\Abstracts\AbstractStatsController;
use Elcodi\AdminCoreBundle\Controller\Interfaces\StatsControllerInterface;

/**
 * Class CartStatsController
 *
 * @Route(
 *      path = "/carts/stats"
 * )
 */
class CartStatsController extends AbstractStatsController implements StatsControllerInterface
{
    /**
     * Get count of all elements
     *
     * @param Request $request Request
     *
     * @return mixed
     *
     * @Route(
     *      path = "/total",
     *      name = "admin_cart_stats_total"
     * )
     * @Template("AdminCoreBundle:Stats:total.html.twig")
     * @Method({"GET"})
     */
    public function totalStatsAction(Request $request)
    {
        return [
            'total' => $this->getTotalStats('elcodi.core.cart.entity.cart.class'),
        ];
    }

    /**
     * Get last month elements count
     *
     * @param Request $request Request
     *
     * @return mixed
     *
     * @Route(
     *      path = "/monthly",
     *      name = "admin_cart_stats_monthly"
     * )
     * @Template("AdminCoreBundle:Stats:monthly.html.twig")
     * @Method({"GET"})
     */
    public function monthlyStatsAction(Request $request)
    {
        return [
            'total' => $this->getMonthlyStats('elcodi.core.cart.entity.cart.class'),
        ];
    }

    /**
     * Get today elements count
     *
     * @param Request $request Request
     *
     * @return mixed
     *
     * @Route(
     *      path = "/daily",
     *      name = "admin_cart_stats_daily"
     * )
     * @Template("AdminCoreBundle:Stats:daily.html.twig")
     * @Method({"GET"})
     */
    public function dailyStatsAction(Request $request)
    {
        return [
            'total' => $this->getDailyStats('elcodi.core.cart.entity.cart.class'),
        ];
    }
}
