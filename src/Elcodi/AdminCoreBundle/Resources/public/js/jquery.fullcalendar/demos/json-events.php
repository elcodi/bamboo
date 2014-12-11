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

$year = date('Y');
    $month = date('m');

    echo json_encode(array(

        array(
            'id' => 111,
            'title' => "Event1",
            'start' => "$year-$month-10",
            'url' => "http://yahoo.com/"
        ),

        array(
            'id' => 222,
            'title' => "Event2",
            'start' => "$year-$month-20",
            'end' => "$year-$month-22",
            'url' => "http://yahoo.com/"
        )

    ));
