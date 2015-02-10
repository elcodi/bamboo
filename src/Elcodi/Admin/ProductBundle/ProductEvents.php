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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Admin\ProductBundle;

/**
 * Events launched related with the bamboo admin product bundle
 */
final class ProductEvents
{
    /**
     * This event is dispatched then the categories order is changed
     *
     * event.name : categories.onorderchange
     */
    const CATEGORIES_ONCHANGE = 'categories.onchange';
}
