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

namespace Elcodi\Plugin\TemplateConverterBundle\Tests\Transformer\Smarty3\Capture;

use Elcodi\Plugin\TemplateConverterBundle\Transformer\Smarty3\Capture\Smarty3Capture;
use PHPUnit_Framework_TestCase;

/**
 * Class Smarty3CaptureTest
 */
class Smarty3CaptureTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test getRegexForCapturing
     */
    public function testGetRegexForCapturing()
    {
        $smarty3Capture = new Smarty3Capture();
        $regexp = $smarty3Capture->getRegexForCapturing();
        preg_match_all(
            $regexp,
            $this->getTemplateCode(),
            $matches
        );

        $this->assertCount(9, $matches[0]);
        $this->assertEquals([
            '{if somevar and isset($hola) or !isset($var)}',
            '{/if}',
            '{include file="$tpl_dir./header.tpl" HOOK_HEADER=$HOOK_HEADER}',
            '{include file="a.tpl" b="hola}"}',
            '{assign var="var" value="value"}',
            '{if $var&&$anothervar||!b}',
            '{/if}',
            '{include file="$tpl_dir./layout/{$LEO_LAYOUT_DIRECTION}/footer.tpl"  }',
            '{if name="{$hola}}"}',
        ], $matches[0]);
    }

    /**
     * get template code
     */
    private function getTemplateCode()
    {
        return <<<EOF
        <div>
    {if somevar and isset(\$hola) or !isset(\$var)}
        <span>
    {/if}

    {include file="\$tpl_dir./header.tpl" HOOK_HEADER=\$HOOK_HEADER}
    {include file="a.tpl" b="hola}"}
    {assign var="var" value="value"}
    {if \$var&&\$anothervar||!b}
        do
    {/if}
    {include file="\$tpl_dir./layout/{\$LEO_LAYOUT_DIRECTION}/footer.tpl"  }
    {if name="{\$hola}}"}
</div>';
EOF;
    }
}
