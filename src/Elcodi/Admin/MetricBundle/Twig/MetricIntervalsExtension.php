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

namespace Elcodi\Admin\MetricBundle\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

use Elcodi\Admin\MetricBundle\Services\MetricIntervalsResolver;

/**
 * Class MetricIntervalsExtension
 */
class MetricIntervalsExtension extends Twig_Extension
{
    /**
     * @var MetricIntervalsResolver
     *
     * Intervals Resolver
     */
    protected $intervalsResolver;

    /**
     * Construct
     *
     * @param MetricIntervalsResolver $intervalsResolver Interval Resolver
     */
    public function __construct(MetricIntervalsResolver $intervalsResolver)
    {
        $this->intervalsResolver = $intervalsResolver;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return Twig_SimpleFunction[] An array of functions
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('metric_create_interval_container', [$this, 'createIntervalContainer']),
        ];
    }

    /**
     * Return metric beacons unique counter
     *
     * @param string $type Type
     *
     * @return integer Beacons unique
     */
    public function createIntervalContainer($type)
    {
        return $this
            ->intervalsResolver
            ->getIntervalContainer($type);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'metric_intervals_extension';
    }
}
