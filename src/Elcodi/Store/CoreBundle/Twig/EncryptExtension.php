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

namespace Elcodi\Store\CoreBundle\Twig;

use Twig_Extension;
use Twig_SimpleFilter;

/**
 * Class EncryptExtension
 */
class EncryptExtension extends Twig_Extension
{
    /**
     * Return all filters
     *
     * @return Twig_SimpleFilter[] Filters
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('sha1', [$this, 'sha1']),
            new Twig_SimpleFilter('md5', [$this, 'md5']),
        ];
    }

    /**
     * Return the sha1 of the value
     *
     * @return string The value encrypted
     */
    public function sha1($value)
    {
        return sha1($value);
    }

    /**
     * Return the md5 of the value
     *
     * @return string The value encrypted
     */
    public function md5($value)
    {
        return md5($value);
    }

    /**
     * return extension name
     *
     * @return string extension name
     */
    public function getName()
    {
        return 'encrypt_extension';
    }
}
