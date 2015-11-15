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

use Elcodi\Plugin\TemplateConverterBundle\Transformer\Interfaces\SimplePieceInterface;

/**
 * Class EmptyPiece
 */
class EmptyPiece implements SimplePieceInterface
{
    /**
     * From regexp
     *
     * @return string Regexp with original data
     */
    public function from()
    {
        return [
            '~({.*?)!empty\((.*?)\)(.*?})~',
            '~({.*?)empty\((.*?)\)(.*?})~'
        ];
    }

    /**
     * To regexp
     *
     * @return string string to replace with
     */
    public function to()
    {
        return [
            '$1$2 is not empty$3',
            '$1$2 is empty$3'
        ];
    }
}
