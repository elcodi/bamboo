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

use Elcodi\Plugin\TemplateConverterBundle\Transformer\Interfaces\PieceInterface;

/**
 * Class IfPiece
 */
class IfPiece implements PieceInterface
{
    /**
     * From regexp
     *
     * @return string Regexp with original data
     */
    public function from()
    {
        return '{if}';
    }

    /**
     * To regexp
     *
     * @return string Regexp with converted data
     */
    public function to()
    {
        return '{{ if }}';
    }
}
