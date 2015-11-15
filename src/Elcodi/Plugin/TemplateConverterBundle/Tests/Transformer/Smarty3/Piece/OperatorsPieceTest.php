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
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Smarty3\Piece\OperatorsPiece;

/**
 * Class OperatorsPieceTest
 */
class OperatorsPieceTest extends AbstractPieceTest
{
    /**
     * get data
     */
    public function getData()
    {
        return [
            ['{if something&&another}', '{if something and another}'],
            ['{if a && b}', '{if a and b}'],
            ['{if a && b&&c}', '{if a and b and c}'],
            ['{if something||another}', '{if something or another}'],
            ['{if a || b}', '{if a or b}'],
            ['{if a || b||c}', '{if a or b or c}'],
            ['{if a || b&&c && (d||e|e)}', '{if a or b and c and (d or e|e)}'],
        ];
    }

    /**
     * get piece
     *
     * @return PieceInterface Piece
     */
    public function getPiece()
    {
        return new OperatorsPiece();
    }
}
