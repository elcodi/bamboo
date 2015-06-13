<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Plugin\DelivereaBundle;

/**
 * Class DelivereaTrackingCodes
 */
class DelivereaTrackingCodes
{
    /**
     * @var string
     *
     * The tracking code prefix.
     */
    const CODE_PREFIX = 'CODE';

    /**
     * @var string
     *
     * The pre transit status code.
     */
    const CODE01 = 'pre-transit';

    /**
     * @var string
     *
     * The in transit status code.
     */
    const CODE02 = 'in-transit';

    /**
     * @var string
     *
     * The out for delivery status code.
     */
    const CODE03 = 'out-for-delivery';

    /**
     * @var string
     *
     * The return to sender status code.
     */
    const CODE04 = 'return-to-sender';

    /**
     * @var string
     *
     * The delivered status code.
     */
    const CODE05 = 'delivered';

    /**
     * @var string
     *
     * The failure status code.
     */
    const CODE06 = 'failure';

    /**
     * @var string
     *
     * The cancelled status code.
     */
    const CODE07 = 'cancelled';
}
