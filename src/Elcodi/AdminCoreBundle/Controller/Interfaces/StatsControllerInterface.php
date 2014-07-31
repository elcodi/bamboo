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

use Symfony\Component\HttpFoundation\Request;

/**
 * Class StatsControllerInterface
 */
interface StatsControllerInterface
{
    /**
     * Get count of all elements
     *
     * @param Request $request Request
     *
     * @return mixed
     */
    public function totalStatsAction(Request $request);

    /**
     * Get last month elements count
     *
     * @param Request $request Request
     *
     * @return mixed
     */
    public function monthlyStatsAction(Request $request);

    /**
     * Get today elements count
     *
     * @param Request $request Request
     *
     * @return mixed
     */
    public function dailyStatsAction(Request $request);
}
