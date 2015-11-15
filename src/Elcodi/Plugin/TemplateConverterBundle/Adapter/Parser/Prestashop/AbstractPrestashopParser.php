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
 
namespace Elcodi\Plugin\TemplateConverterBundle\Adapter\Parser\Prestashop;
use Elcodi\Plugin\TemplateConverterBundle\Adapter\Parser\Abstracts\AbstractTemplateParser;

/**
 * Class AbstractPrestashopParser
 */
abstract class AbstractPrestashopParser extends AbstractTemplateParser
{
    /**
     * Get skeleton file
     *
     * @param string $fileName  Skeleton file name
     * @param array  $variables Variable to replace
     *
     * @return string File content
     */
    protected function getSkeletonFileContent($fileName, $variables = [])
    {
        $globalVariables = [];
        $variables = array_merge(
            $globalVariables,
            $variables
        );

        return parent::getSkeletonFileContent($fileName, $variables);
    }
}
