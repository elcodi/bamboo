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
 
namespace Elcodi\Plugin\TemplateConverterBundle\Tests\Transformer\Smarty3\Piece;

use Elcodi\Plugin\TemplateConverterBundle\Tests\Transformer\Abstracts\AbstractPieceTest;
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Interfaces\PieceInterface;
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Smarty3\Piece\InArrayPiece;

/**
 * Class InArrayPieceTest
 */
class InArrayPieceTest extends AbstractPieceTest
{
    /**
     * get data
     */
    public function getData()
    {
        return [
            ['{if   in_array($my_var, $array)   || $b}', '{if $my_var in $array|keys || $b}'],
            ['{if in_array($a, $b)||$c}', '{if $a in $b|keys ||$c}'],
            ['{if $c}in_array($a, $b)', '{if $c}in_array($a, $b)'],
            ['{if in_array($a, array($b))}', '{if $a in array($b)|keys }'],
            ['{if in_array($a, whatever($b))}', '{if $a in whatever($b)|keys }'],
            ['{if in_array("hi,there", $b)}', '{if "hi,there" in $b|keys }'],
        ];
    }

    /**
     * get piece
     *
     * @return PieceInterface Piece
     */
    public function getPiece()
    {
        return new InArrayPiece();
    }
}
