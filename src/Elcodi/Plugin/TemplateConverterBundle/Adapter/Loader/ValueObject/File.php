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

namespace Elcodi\Plugin\TemplateConverterBundle\Adapter\Loader\ValueObject;

/**
 * Class File
 */
class File
{
    /**
     * @var string
     *
     * Filename
     */
    private $filename;

    /**
     * @var string
     *
     * Data
     */
    private $data;

    /**
     * Construct
     *
     * @param string $filename File name
     * @param string $data     Data
     */
    public function __construct($filename, $data)
    {
        $this->filename = $filename;
        $this->data = $data;
    }

    /**
     * Get Filename
     *
     * @return string Filename
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Get Data
     *
     * @return string Data
     */
    public function getData()
    {
        return $this->data;
    }
}
