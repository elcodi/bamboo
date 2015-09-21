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
 
namespace ApiRest\Api\Normalizer;

/**
 * Class FieldNormalizer
 */
class FieldNormalizer
{
    /**
     * Normalize
     */
    public static function normalize($relationship)
    {
        return strtolower(preg_replace('/[A-Z]/', '_\\0', $relationship));
    }

    /**
     * Normalize
     */
    public static function denormalize($relationship)
    {
        $relationship = preg_replace('/_/', ' ', $relationship);
        $relationship = lcfirst(ucwords($relationship));
        return preg_replace('/\s/', '', $relationship);
    }
}
