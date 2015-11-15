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
 
namespace Elcodi\Plugin\TemplateConverterBundle\Transformer\Interfaces;

/**
 * Interface CodeCaptureInterface
 */
interface CodeCaptureInterface
{
    /**
     * Return the regex to capture all template valid pieces from a file.
     * This is very template language specific
     *
     * @return string Regex to capture all template code
     */
    public function getRegexForCapturing();
}
