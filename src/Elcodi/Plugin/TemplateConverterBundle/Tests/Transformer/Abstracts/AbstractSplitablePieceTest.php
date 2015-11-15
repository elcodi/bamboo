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
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Interfaces\SplitablePieceInterface;
use PHPUnit_Framework_TestCase;

/**
 * Class AbstractSplitablePieceTest
 */
abstract class AbstractSplitablePieceTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test
     *
     * @dataProvider getData
     */
    public function testPiece($input, $output)
    {
        /**
         * @var SplitablePieceInterface $piece
         */
        $piece = $this->getPiece();
        $result = $input;
        while (preg_match_all(
                $piece->fromSplit(),
                $result,
                $matches,
                PREG_PATTERN_ORDER
            ) > 0) {

            if (isset($matches[0])) {
                foreach ($matches[0] as $match) {

                    $result = str_replace(
                        $match,
                        $piece->toSplit($match),
                        $result
                    );
                }
            }
        }

        $this->assertEquals(
            $output,
            $result
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
