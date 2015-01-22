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
 */

namespace Elcodi\Admin\ProductBundle\Controller\Stats;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractStatsController;

/**
 * Class ProductStatsController
 *
 * @Route(
 *      path = "/products/stats"
 * )
 */
class ProductStatsController extends AbstractStatsController
{
    /**
     * Get count of all elements
     *
     * @return mixed
     *
     * @Route(
     *      path = "/total",
     *      name = "admin_product_stats_total"
     * )
     * @Template("AdminProductBundle:Product:Stats/total.html.twig")
     * @Method({"GET"})
     */
    public function totalStatsAction()
    {
        return [
            'total' => $this->getTotalStats('elcodi.core.product.entity.product.class'),
        ];
    }

    /**
     * Get last month elements count
     *
     * @return mixed
     *
     * @Route(
     *      path = "/monthly",
     *      name = "admin_product_stats_monthly"
     * )
     * @Template("AdminProductBundle:Product:Stats/monthly.html.twig")
     * @Method({"GET"})
     */
    public function monthlyStatsAction()
    {
        return [
            'total' => $this->getMonthlyStats('elcodi.core.product.entity.product.class'),
        ];
    }

    /**
     * Get today elements count
     *
     * @return mixed
     *
     * @Route(
     *      path = "/daily",
     *      name = "admin_product_stats_daily"
     * )
     * @Template("AdminProductBundle:Product:Stats/daily.html.twig")
     * @Method({"GET"})
     */
    public function dailyStatsAction()
    {
        return [
            'total' => $this->getDailyStats('elcodi.core.product.entity.product.class'),
        ];
    }
}
