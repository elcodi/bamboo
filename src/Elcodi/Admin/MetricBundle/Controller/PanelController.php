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

namespace Elcodi\Admin\MetricBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Elcodi\Admin\MetricBundle\AdminPanelTypes;

/**
 * Class Panel Controller
 *
 * @Route(
 *      path = "panel"
 * )
 */
class PanelController
{
    /**
     * View today's panel
     *
     * @Route(
     *      path = "/today",
     *      name = "admin_metric_panel_today",
     *      methods = {"GET"}
     * )
     * @Template("AdminMetricBundle:Panel:panel.html.twig")
     */
    public function metricPanelTodayAction()
    {
        return [
            'type' => AdminPanelTypes::PANEL_TYPE_TODAY,
        ];
    }

    /**
     * View yesterday's panel
     *
     * @Route(
     *      path = "/yesterday",
     *      name = "admin_metric_panel_yesterday",
     *      methods = {"GET"}
     * )
     * @Template("AdminMetricBundle:Panel:panel.html.twig")
     */
    public function metricPanelYesterdayAction()
    {
        return [
            'type' => AdminPanelTypes::PANEL_TYPE_YESTERDAY,
        ];
    }

    /**
     * View last week's panel
     *
     * @Route(
     *      path = "/last/week",
     *      name = "admin_metric_panel_last_week",
     *      methods = {"GET"}
     * )
     * @Template("AdminMetricBundle:Panel:panel.html.twig")
     */
    public function metricPanelLastWeekAction()
    {
        return [
            'type' => AdminPanelTypes::PANEL_TYPE_LAST_WEEK,
        ];
    }

    /**
     * View last month's panel
     *
     * @Route(
     *      path = "/last/month",
     *      name = "admin_metric_panel_last_month",
     *      methods = {"GET"}
     * )
     * @Template("AdminMetricBundle:Panel:panel.html.twig")
     */
    public function metricPanelLastMonthAction()
    {
        return [
            'type' => AdminPanelTypes::PANEL_TYPE_LAST_MONTH,
        ];
    }

    /**
     * View last quarter's panel
     *
     * @Route(
     *      path = "/last/quarter",
     *      name = "admin_metric_panel_last_quarter",
     *      methods = {"GET"}
     * )
     * @Template("AdminMetricBundle:Panel:panel.html.twig")
     */
    public function metricPanelLastQuarterAction()
    {
        return [
            'type' => AdminPanelTypes::PANEL_TYPE_LAST_QUARTER,
        ];
    }
}
