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

$targ_w = $targ_h = 150;
    $jpeg_quality = 90;

    $src = $_GET["src"];
    $img_r = imagecreatefromjpeg($src);
    $dst_r = ImageCreateTrueColor($targ_w, $targ_h);

    imagecopyresampled($dst_r, $img_r, 0, 0, $_GET['x'], $_GET['y'],
    $targ_w, $targ_h, $_GET['w'], $_GET['h']);

    header('Content-type: image/jpeg');
    imagejpeg($dst_r, null, $jpeg_quality);

    exit;
