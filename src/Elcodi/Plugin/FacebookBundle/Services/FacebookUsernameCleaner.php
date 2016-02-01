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

namespace Elcodi\Plugin\FacebookBundle\Services;

/**
 * Class FacebookUsernameCleaner
 */
class FacebookUsernameCleaner
{
    /**
     * Cleans a facebook url username to save only the username
     *
     * @param string $facebookUsername The facebook url or username
     *
     * @return string A facebook username
     */
    public function clean($facebookUsername)
    {
        $regex = "/(?:^https?:\/\/(?:www\.)?facebook\.com\/)?([^?\/]+)(.)*$/";

        return preg_replace($regex, "$1", $facebookUsername);
    }
}
