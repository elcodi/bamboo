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

namespace Elcodi\Store\CoreBundle\EventListener\Abstracts;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractStoreEventListener
 */
abstract class AbstractStoreEventListener
{
    /**
     * Check if current request is in store
     *
     * @param Request $request     Request
     * @param string  $adminPrefix Admin prefix
     *
     * @return boolean In store
     */
    protected function inStore(Request $request, $adminPrefix)
    {
        $route = $request->getRequestUri();
        preg_match('(_(profiler|wdt)|css|images|js|'.$adminPrefix.')', $route, $matched);

        return empty($matched);
    }
}
