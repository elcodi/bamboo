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

namespace Elcodi\Admin\MetricBundle;

/**
 * Class AdminPanelTypes
 */
class AdminPanelTypes
{
    /**
     * @param integer
     *
     * Panel type today
     */
    const PANEL_TYPE_TODAY = 1;

    /**
     * @param integer
     *
     * Panel type yesterday
     */
    const PANEL_TYPE_YESTERDAY = 2;

    /**
     * @param integer
     *
     * Panel type last week
     */
    const PANEL_TYPE_LAST_WEEK = 3;

    /**
     * @param integer
     *
     * Panel type last month
     */
    const PANEL_TYPE_LAST_MONTH = 4;

    /**
     * @param integer
     *
     * Panel type last quarter
     */
    const PANEL_TYPE_LAST_QUARTER = 5;
}
