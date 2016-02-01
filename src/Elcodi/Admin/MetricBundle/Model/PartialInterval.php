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

/**
 * Class PartialInterval
 */
class PartialInterval
{
    /**
     * @var array
     *
     * Elements
     */
    private $elements;

    /**
     * @var string
     *
     * First
     */
    private $first;

    /**
     * Construct
     *
     * @param array  $elements Elements
     * @param string $first    First
     */
    public function __construct(array $elements, $first)
    {
        $this->elements = $elements;
        $this->first = $first;
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
     * Get First
     *
     * @return string First
     */
    public function getFirst()
    {
        return $this->first;
    }

    /**
     * Static creation
     *
     * @param array  $elements Elements
     * @param string $first    First
     *
     * @return self New instance
     */
    public static function create(array $elements, $first)
    {
        return new self($elements, $first);
    }
}
