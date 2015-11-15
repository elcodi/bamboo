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
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Smarty3\Piece\IncludePiece;

/**
 * Class IncludePieceTest
 */
class IncludePieceTest extends AbstractSplitablePieceTest
{
    /**
     * get data
     */
    public function getData()
    {
        return [
            [
                '
{include file="file1" var1=$val1}
{include file="file2" title="title1" var2="val2" var3=\'val3\'}
{include file="\$tpl_dir./header.tpl" HOOK_HEADER=$HOOK_HEADER}
{include file="file3" assign="assignable1"}',
                '
{% include "file1" with {var1: $val1} %}
{% include "file2" with {title: "title1", var2: "val2", var3: \'val3\'} %}
{% include "\$tpl_dir./header.tpl" with {HOOK_HEADER: $HOOK_HEADER} %}
{% include "file3" %}'
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
        return new IncludePiece();
    }
}
