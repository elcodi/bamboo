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

namespace Elcodi\Admin\MetricBundle\Model;

use DateTime;

/**
 * Class IntervalContainer
 */
class IntervalContainer
{
    /**
     * @var DateTime
     *
     * startDay
     */
    private $startDay;

    /**
     * @var int
     *
     * iterations
     */
    private $iterations;

    /**
     * @var array
     *
     * elementsIntervalFormat
     */
    private $elementsIntervalFormat;

    /**
     * @var int
     *
     * elementsGrouping
     */
    private $elementsGrouping;

    /**
     * @var string
     *
     * elementsFormat
     */
    private $elementsFormat;

    /**
     * @var int
     *
     * chartElementsSeparation
     */
    private $chartElementsSeparation;

    /**
     * @var string
     *
     * chartLegendFormat
     */
    private $chartLegendFormat;

    /**
     * @var PartialInterval[]
     *
     * partial Intervals
     */
    private $partialIntervals;

    /**
     * @var string[]
     *
     * elements
     */
    private $elements;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->startDay = new DateTime();
        $this->iterations = 23;
        $this->elementsIntervalFormat = ['PT', 1, 'H'];
        $this->elementsGrouping = 1;
        $this->elementsFormat = 'Y-m-d-H';
        $this->chartElementsSeparation = 2;
        $this->chartLegendFormat = 'ha';
        $this->partialIntervals = [];
        $this->elements = [];
    }

    /**
     * Get StartDay
     *
     * @return DateTime StartDay
     */
    public function getStartDay()
    {
        return $this->startDay;
    }

    /**
     * Sets StartDay
     *
     * @param DateTime $startDay StartDay
     *
     * @return $this Self object
     */
    public function setStartDay(DateTime $startDay)
    {
        $this->startDay = $startDay;

        return $this;
    }

    /**
     * Resets the start day hour
     *
     * @return $this Self object
     */
    public function resetHourStartDay()
    {
        $this
            ->startDay
            ->setTime(0, 0, 0);

        return $this;
    }

    /**
     * Get Iterations
     *
     * @return int Iterations
     */
    public function getIterations()
    {
        return $this->iterations;
    }

    /**
     * Sets Iterations
     *
     * @param int $iterations Iterations
     *
     * @return $this Self object
     */
    public function setIterations($iterations)
    {
        $this->iterations = $iterations;

        return $this;
    }

    /**
     * Get ElementsIntervalFormat
     *
     * @return array ElementsIntervalFormat
     */
    public function getElementsIntervalFormat()
    {
        return $this->elementsIntervalFormat;
    }

    /**
     * Sets ElementsIntervalFormat
     *
     * @param array $elementsIntervalFormat ElementsIntervalFormat
     *
     * @return $this Self object
     */
    public function setElementsIntervalFormat($elementsIntervalFormat)
    {
        $this->elementsIntervalFormat = $elementsIntervalFormat;

        return $this;
    }

    /**
     * Get ElementsGrouping
     *
     * @return int ElementsGrouping
     */
    public function getElementsGrouping()
    {
        return $this->elementsGrouping;
    }

    /**
     * Sets ElementsGrouping
     *
     * @param int $elementsGrouping ElementsGrouping
     *
     * @return $this Self object
     */
    public function setElementsGrouping($elementsGrouping)
    {
        $this->elementsGrouping = $elementsGrouping;

        return $this;
    }

    /**
     * Get ElementsFormat
     *
     * @return string ElementsFormat
     */
    public function getElementsFormat()
    {
        return $this->elementsFormat;
    }

    /**
     * Sets ElementsFormat
     *
     * @param string $elementsFormat ElementsFormat
     *
     * @return $this Self object
     */
    public function setElementsFormat($elementsFormat)
    {
        $this->elementsFormat = $elementsFormat;

        return $this;
    }

    /**
     * Get ChartElementsSeparation
     *
     * @return int ChartElementsSeparation
     */
    public function getChartElementsSeparation()
    {
        return $this->chartElementsSeparation;
    }

    /**
     * Sets ChartElementsSeparation
     *
     * @param int $chartElementsSeparation ChartElementsSeparation
     *
     * @return $this Self object
     */
    public function setChartElementsSeparation($chartElementsSeparation)
    {
        $this->chartElementsSeparation = $chartElementsSeparation;

        return $this;
    }

    /**
     * Get ChartLegendFormat
     *
     * @return string ChartLegendFormat
     */
    public function getChartLegendFormat()
    {
        return $this->chartLegendFormat;
    }

    /**
     * Sets ChartLegendFormat
     *
     * @param string $chartLegendFormat ChartLegendFormat
     *
     * @return $this Self object
     */
    public function setChartLegendFormat($chartLegendFormat)
    {
        $this->chartLegendFormat = $chartLegendFormat;

        return $this;
    }

    /**
     * Get PartialElements
     *
     * @return PartialInterval[] PartialElements
     */
    public function getPartialIntervals()
    {
        return $this->partialIntervals;
    }

    /**
     * Add Partial Interval
     *
     * @param PartialInterval $partialInterval Partial Interval
     *
     * @return $this Self object
     */
    public function addPartialInterval(PartialInterval $partialInterval)
    {
        $this->partialIntervals[] = $partialInterval;

        return $this;
    }

    /**
     * Get Elements
     *
     * @return array Elements
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * Sets Element
     *
     * @param string $element Element
     *
     * @return $this Self object
     */
    public function addElement($element)
    {
        $this->elements[] = $element;

        return $this;
    }

    /**
     * Static creation
     *
     * @return self New instance
     */
    public static function create()
    {
        return new self();
    }
}
