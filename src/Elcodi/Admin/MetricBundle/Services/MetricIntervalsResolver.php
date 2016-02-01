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

namespace Elcodi\Admin\MetricBundle\Services;

use DateTime;

use Elcodi\Admin\MetricBundle\AdminPanelTypes;
use Elcodi\Admin\MetricBundle\Model\IntervalContainer;
use Elcodi\Admin\MetricBundle\Model\PartialInterval;

/**
 * Class MetricIntervalsResolver
 */
class MetricIntervalsResolver
{
    /**
     * Given a type, create and configure the interval container
     *
     * @param integer $type Type of calculation
     *
     * @return IntervalContainer
     */
    public function getIntervalContainer($type)
    {
        $intervalContainer = IntervalContainer::create();
        $now = new DateTime();

        switch ($type) {

            /**
             * Today
             */
            case AdminPanelTypes::PANEL_TYPE_TODAY:
                break;

            /**
             * Yesterday
             */
            case AdminPanelTypes::PANEL_TYPE_YESTERDAY:
                $intervalContainer->setStartDay(DateTime::createFromFormat('U', strtotime("-1 day"), $now->getTimezone()));
                break;

            /**
             * Last 7 days
             */
            case AdminPanelTypes::PANEL_TYPE_LAST_WEEK:
                $intervalContainer
                    ->setStartDay(DateTime::createFromFormat('U', strtotime("-6 day"), $now->getTimezone()))
                    ->setElementsIntervalFormat(['PT', 1, 'H'])
                    ->setIterations(167)
                    ->setElementsGrouping(3)
                    ->setChartElementsSeparation(8)
                    ->setChartLegendFormat('M. j');
                break;

            /**
             * Last 30 days
             */
            case AdminPanelTypes::PANEL_TYPE_LAST_MONTH:
                $intervalContainer
                    ->setStartDay(DateTime::createFromFormat('U', strtotime("-29 day"), $now->getTimezone()))
                    ->setElementsIntervalFormat(['P', 1, 'D'])
                    ->setIterations(29)
                    ->setElementsFormat('Y-m-d')
                    ->setChartElementsSeparation(4)
                    ->setChartLegendFormat('M. j');
                break;

            /**
             * Last 90 days
             */
            case AdminPanelTypes::PANEL_TYPE_LAST_QUARTER:
                $intervalContainer
                    ->setStartDay(DateTime::createFromFormat('U', strtotime("-89 day"), $now->getTimezone()))
                    ->setElementsIntervalFormat(['P', 1, 'D'])
                    ->setIterations(89)
                    ->setElementsFormat('Y-m-d')
                    ->setChartElementsSeparation(8)
                    ->setChartLegendFormat('M. j');
                break;
        }

        $intervalContainer->resetHourStartDay();
        $startDay = $intervalContainer->getStartDay();
        $iterations = $intervalContainer->getIterations();
        $elementsIntervalFormat = $intervalContainer->getElementsIntervalFormat();
        $elementsFormat = $intervalContainer->getElementsFormat();
        $elementsGrouping = $intervalContainer->getElementsGrouping();

        $timeElements = [$startDay];
        for ($i = 1; $i <= $iterations; $i++) {
            $time = clone $startDay;
            $time->add(new \DateInterval($elementsIntervalFormat[0] . $i * $elementsIntervalFormat[1] . $elementsIntervalFormat[2]));
            $timeElements[] = $time;
        }

        $timeElement = reset($timeElements);

        while ($timeElement instanceof \DateTime) {
            $firstTimeElement = clone $timeElement;
            $elementFormatted = $timeElement->format($elementsFormat);
            $intervalContainer->addElement($elementFormatted);
            $groupedPartials = [$elementFormatted];
            for ($k = 1; $k < $elementsGrouping; $k++) {
                $timeElement = next($timeElements);
                $elementFormatted = $timeElement->format($elementsFormat);
                $intervalContainer->addElement($elementFormatted);
                $groupedPartials[] = $elementFormatted;
            }

            $intervalContainer->addPartialInterval(PartialInterval::create(
                $groupedPartials,
                $firstTimeElement
            ));

            $timeElement = next($timeElements);
        }

        return $intervalContainer;
    }
}
