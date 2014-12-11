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

namespace Elcodi\AdminCoreBundle\Controller\Interfaces;

/**
 * Class StatsControllerInterface
 */
interface StatsControllerInterface
{
    /**
     * Get count of all elements
     *
     * @return mixed
     */
    public function totalStatsAction();

    /**
     * Get last month elements count
     *
     * @return mixed
     */
    public function monthlyStatsAction();

    /**
     * Get today elements count
     *
     * @return mixed
     */
    public function dailyStatsAction();
}
