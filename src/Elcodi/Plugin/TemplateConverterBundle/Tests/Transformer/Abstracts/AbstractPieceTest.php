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

namespace Elcodi\Plugin\TemplateConverterBundle\Tests\Transformer\Abstracts;

use Elcodi\Plugin\TemplateConverterBundle\Transformer\Interfaces\PieceInterface;
use PHPUnit_Framework_TestCase;

/**
 * Class AbstractPieceTest
 */
abstract class AbstractPieceTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test
     *
     * @dataProvider getData
     */
    public function testPiece($input, $output)
    {
        $piece = $this->getPiece();
        do {
            $newData = preg_replace(
                $piece->from(),
                $piece->to(),
                $input
            );
        } while ($newData != $input && $input = $newData);

        $this->assertEquals(
            $output,
            $newData
        );
    }

    /**
     * get data
     */
    abstract public function getData();

    /**
     * get piece
     *
     * @return PieceInterface Piece
     */
    abstract public function getPiece();
}
