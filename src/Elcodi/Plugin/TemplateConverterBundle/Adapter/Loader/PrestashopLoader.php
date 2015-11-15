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
 
namespace Elcodi\Plugin\TemplateConverterBundle\Adapter\Loader;
use Elcodi\Plugin\TemplateConverterBundle\Adapter\Loader\Abstracts\AbstractProjectLoader;

/**
 * Class PrestashopLoader
 */
class PrestashopLoader extends AbstractProjectLoader
{
    /**
     * Get the project skeleton. The result must be like follows
     *
     * [
     *      "file1.tpl",
     *      "file2.txt",
     *      "folder/*.tpl",
     *      ...
     * ]
     */
    protected function getProjectSkeleton()
    {
        return [
            '/',
        ];
    }
}
