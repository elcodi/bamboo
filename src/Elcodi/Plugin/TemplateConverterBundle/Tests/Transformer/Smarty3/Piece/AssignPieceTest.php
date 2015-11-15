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

use Elcodi\Plugin\TemplateConverterBundle\Tests\Transformer\Abstracts\AbstractSplitablePieceTest;
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Interfaces\PieceInterface;
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Smarty3\Piece\AssignPiece;

/**
 * Class AssignPieceTest
 */
class AssignPieceTest extends AbstractSplitablePieceTest
{
    /**
     * get data
     */
    public function getData()
    {
        return [
            [
                '
{assign var="var1" value="val1"}
{assign var="var1" value=\'val1\'}
{assign var=\'right_column_size\' value=0}',
                '
{% set var1 = "val1" %}
{% set var1 = \'val1\' %}
{% set right_column_size = 0 %}'
            ],
        ];
    }

    /**
     * get piece
     *
     * @return PieceInterface Piece
     */
    public function getPiece()
    {
        return new AssignPiece();
    }
}
