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

namespace Elcodi\Admin\MetricBundle\Controller;

use DateInterval;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class MetricController
 */
class MetricController
{
    /**
     * View metric graph
     *
     * @Route(
     *      path = "metric/last24hours/{tracker}/{event}",
     *      name = "admin_metric_last_24_hours",
     *      methods = {"GET"}
     * )
     * @Template
     */
    public function viewLast24HoursAction($tracker, $event)
    {
        $timeElements = [];
        for ($i = 11; $i >= 0; $i--) {

            $time = new DateTime();
            $time->sub(new DateInterval('PT' . $i . 'H'));
            $timeElements[] = $time;
        }

        return [
            'timeElements' => $timeElements,
            'tracker'      => $tracker,
            'event'        => $event,
        ];
    }
}
