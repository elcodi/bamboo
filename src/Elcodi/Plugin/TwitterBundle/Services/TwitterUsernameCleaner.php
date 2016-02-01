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

namespace Elcodi\Plugin\TwitterBundle\Services;

/**
 * Class TwitterUsernameCleaner
 */
class TwitterUsernameCleaner
{
    /**
     * Cleans a twitter username to save only the username without the '@'
     *
     * @param string $twitterUsername The twitter url or username
     *
     * @return string A twitter username
     */
    public function clean($twitterUsername)
    {
        $regex = "/^@?(.+)$/";

        return preg_replace($regex, "$1", $twitterUsername);
    }
}
