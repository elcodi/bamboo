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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ReportsController
 *
 * @Route(
 *      path = "reports/"
 * )
 */
class ReportsController extends Controller
{
    /**
     * View reports
     *
     * @param string $panel Panel type
     *
     * @return array
     *
     * @Route(
     *      path = "today",
     *      name = "admin_reports_today",
     *      defaults = {
     *          "panel" = "metricPanelToday"
     *      },
     *      methods = {"GET"}
     * )
     *
     * @Route(
     *      path = "yesterday",
     *      name = "admin_reports_yesterday",
     *      defaults = {
     *          "panel" = "metricPanelYesterday"
     *      },
     *      methods = {"GET"}
     * )
     *
     * @Route(
     *      path = "last/week",
     *      name = "admin_reports_last_week",
     *      defaults = {
     *          "panel" = "metricPanelLastWeek"
     *      },
     *      methods = {"GET"}
     * )
     *
     * @Route(
     *      path = "last/month",
     *      name = "admin_reports_last_month",
     *      defaults = {
     *          "panel" = "metricPanelLastMonth"
     *      },
     *      methods = {"GET"}
     * )
     *
     * @Route(
     *      path = "last/quarter",
     *      name = "admin_reports_last_quarter",
     *      defaults = {
     *          "panel" = "metricPanelLastQuarter"
     *      },
     *      methods = {"GET"}
     * )
     *
     * @Template()
     */
    public function viewAction($panel)
    {
        return [
            'panel' => $panel,
        ];
    }
}
