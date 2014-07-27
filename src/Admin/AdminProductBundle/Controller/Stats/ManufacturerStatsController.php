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

namespace Admin\AdminProductBundle\Controller\Stats;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Admin\AdminCoreBundle\Controller\Interfaces\StatsControllerInterface;
use Admin\AdminCoreBundle\Controller\Abstracts\AbstractStatsController;

/**
 * Class ManufacturerStatsController
 *
 * @Route(
 *      path = "/manufacturers/stats"
 * )
 */
class ManufacturerStatsController extends AbstractStatsController implements StatsControllerInterface
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
     *      name = "admin_manufacturer_stats_total"
     * )
     * @Template("AdminCoreBundle:Stats:total.html.twig")
     * @Method({"GET"})
     */
    public function totalStatsAction(Request $request)
    {
        return [
            'total' => $this->getTotalStats('elcodi.core.product.entity.manufacturer.class'),
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
     *      name = "admin_manufacturer_stats_monthly"
     * )
     * @Template("AdminCoreBundle:Stats:monthly.html.twig")
     * @Method({"GET"})
     */
    public function monthlyStatsAction(Request $request)
    {
        return [
            'total' => $this->getMonthlyStats('elcodi.core.product.entity.manufacturer.class'),
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
     *      name = "admin_manufacturer_stats_daily"
     * )
     * @Template("AdminCoreBundle:Stats:daily.html.twig")
     * @Method({"GET"})
     */
    public function dailyStatsAction(Request $request)
    {
        return [
            'total' => $this->getDailyStats('elcodi.core.product.entity.manufacturer.class'),
        ];
    }
}
