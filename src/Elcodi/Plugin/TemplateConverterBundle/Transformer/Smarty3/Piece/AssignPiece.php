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
 
namespace Elcodi\Plugin\TemplateConverterBundle\Transformer\Smarty3\Piece;

use Elcodi\Plugin\TemplateConverterBundle\Exception\TemplateFormatException;
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Interfaces\SplitablePieceInterface;

/**
 * Class AssignPiece
 */
class AssignPiece implements SplitablePieceInterface
{
    /**
     * To regexp
     *
     * @return string string to replace with
     */
    public function fromSplit()
    {
        return '~{\s*assign\s+.*?}~';
    }

    /**
     * To regexp
     *
     * @param string $content Content
     *
     * @return string string to replace with
     *
     * @throws TemplateFormatException Bad format
     */
    public function toSplit($content)
    {
        preg_match_all(
            '~(?:(?:^|\s+)(\S+)\s*=\s*("[^"]*"|\'[^\']*\'|(\w|\$)*))~',
            $content,
            $matches
        );

        $elements = [];
        if (isset($matches[0])) {
            foreach ($matches[0] as $match) {
                list($key, $value) = explode('=', $match, 2);
                $elements[trim($key)] = trim($value);
            }
        }

        if (!isset($elements['var']) || !isset($elements['value'])) {
            throw new TemplateFormatException('Bad {assign} format : ' . $content);
        }

        return '{% set ' . trim($elements['var'], '\'"') . ' = ' . $elements['value'] . ' %}';
    }
}
