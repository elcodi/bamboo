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
 
namespace Elcodi\Plugin\TemplateConverterBundle\Transformer\Smarty3\Piece\Helper;

/**
 * Trait CapturingHelper
 */
trait CapturingHelper
{
    /**
     * Get specific smarty block
     *
     * > { include ... }
     * > { if ... }
     *
     * @param string $blockName Block name
     *
     * @return string
     */
    protected function getSmartyBlock($blockName)
    {
        return '~{\s*' . $blockName . '\s+.*}~';
    }

    /**
     * Get quoted content
     *
     * > "quoted content" not quoted content 'quoted content'
     *
     * @return string
     */
    protected function getAllQuotedContent()
    {
        return '~("|\').*?(?<!\\\\)\1~';
    }

    /**
     * Get quoted content
     *
     * > "not simple quoted content" not quoted content 'simple quoted content'
     *
     * @return string
     */
    protected function getSingleQuotedContent()
    {
        return '~\'.*?(?<!\\\\)\'~';
    }

    /**
     * Get equal pairs
     *
     * > key=$value key2="value2" key3='value3'
     *                          
     * @return string
     */
    protected function getKeyValuePairs()
    {
        return '~(\S*=(?:("|\').*?(?<!\\\\)\2|\$[A-Za-z0-9_]+))+~';
    }

    /**
     * Get inside a string
     *
     * > whatever "this is what we need" another thing
     * > whatever 'this is what we need' another thing
     *
     * @param string $content Content inside string
     *
     * @return string
     */
    protected function getFromInsideString($content)
    {
        return '~(\'|")(.*?)' . $content . '(.*?)(?<!\\\\)\1~';
    }

    /**
     * Get inside a string
     *
     * > whatever "this is what we need" another thing
     * > whatever 'this is what we need' another thing
     *
     * @param string $content Content inside string
     *
     * @return string
     */
    protected function getFromOutsideString($content)
    {
        return '~(?:(?:(\'|")(?:.*?)(?<!\\\\)\1)|(' . $content . ')|(?:.*?))*~';
    }
}
