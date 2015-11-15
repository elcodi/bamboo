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
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Smarty3\Piece\Helper\CapturingHelper;

/**
 * Class IncludePiece
 */
class IncludePiece implements SplitablePieceInterface
{
    use CapturingHelper;

    /**
     * To regexp
     *
     * @return string string to replace with
     */
    public function fromSplit()
    {
        return $this->getSmartyBlock('include');
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
            $this->getKeyValuePairs(),
            $content,
            $matches
        );

        $elements = [];
        foreach ($matches[0] as $match) {
            list($key, $value) = explode('=', $match, 2);
            $elements[trim($key)] = trim($value);
        }

        if (!isset($elements['file'])) {
            throw new TemplateFormatException('Bad {include} format : ' . $content);
        }

        $result = '{% include ' . $elements['file'];

        unset($elements['file']);
        if (isset($elements['assign'])) {
            unset($elements['assign']);
        }

        $elementsFormatted = [];
        foreach ($elements as $elementKey => $elementValue) {

            $elementsFormatted[] = $elementKey . ': ' . $elementValue;
        }

        if (!empty($elementsFormatted)) {
            $result .= ' with {' . implode(', ', $elementsFormatted). '}';
        }

        return $result . ' %}';
    }
}
