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

namespace ApiRest\Api;

/**
 * Class ApiRoutes
 */
class ApiRoutes
{
    /**
     * @var string
     *
     * List action
     */
    const API_GET = 1;

    /**
     * @var string
     *
     * List action
     */
    const API_POST = 2;

    /**
     * @var string
     *
     * List action
     */
    const API_PUT = 4;

    /**
     * @var string
     *
     * List action
     */
    const API_DELETE = 8;

    /**
     * Get all verbs
     *
     * @return array All verbs
     */
    public static function all()
    {
        return [
            self::API_GET    => 'get',
            self::API_POST   => 'post',
            self::API_PUT    => 'put',
            self::API_DELETE => 'delete',
        ];
    }

    /**
     * Get all valid verbs given required level
     *
     * @param integer $level Required level
     *
     * @return array Valid verbs
     */
    public static function valid($level)
    {
        return array_filter(
            array_keys(self::all()),
            function ($verb) use ($level) {
                return self::isValid(
                    $level,
                    $verb
                );
            }
        );
    }

    /**
     * get validity of a verb
     *
     * @param integer $level Required level
     * @param integer $verb
     *
     * @return array Valid verbs
     */
    public static function isValid($level, $verb)
    {
        return $verb & $level;
    }

    /**
     * To verb
     *
     * @param integer $code Code
     *
     * @return string verb given integer
     */
    public static function toVerb($code)
    {
        $verbs = self::all();

        return $verbs[$code];
    }

    /**
     * To verb
     *
     * @param integer $verb Verb
     *
     * @return string verb given integer
     */
    public static function toCode($verb)
    {
        $codes = array_flip(self::all());

        return $codes[$verb];
    }
}
