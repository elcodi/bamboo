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
 
namespace Elcodi\Plugin\TemplateConverterBundle\Tests\Transformer\Smarty3;
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Smarty3\TemplateTransformer;
use PHPUnit_Framework_TestCase;

/**
 * Class TemplateTransformerTest
 */
class TemplateTransformerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test to Twig
     */
    public function testToTwig()
    {
        $transformer = new TemplateTransformer();
        $this->assertEquals(
            $this->getTo(),
            $transformer->toTwig(
                $this->getFrom()
            )
        );
    }

    /**
     * Get from
     */
    public function getFrom()
    {
        return <<<EOF
<div>
    {if \$somevar and isset(\$hola) or !isset(\$var)}
        <span>
    {/if}

    {include file="\$tpl_dir./header.tpl" HOOK_HEADER=\$HOOK_HEADER}
    {include file="a.tpl" b="hola}"}
    {assign var="var" value="value"}
    {if \$var&&\$anothervar||!b}
        do
    {/if}
    {include file="\$tpl_dir./layout/{\$LEO_LAYOUT_DIRECTION}/footer.tpl"  }
</div>
EOF;

    }

    /**
     * Get to
     */
    public function getTo()
    {
        return <<<EOF
<div>
    {% if \$somevar and \$hola is defined or \$var is not defined %}
        <span>
    {% endif %}

    {% include "@~~bundle_name~~/header.tpl" with {HOOK_HEADER: \$HOOK_HEADER} %}
    {% include "a.tpl" with {b: "hola}"} %}
    {% set var = "value" %}
    {% if \$var and \$anothervar or not \$b %}
        do
    {% endif %}
    {% include "@~~bundle_name~~/layout/" ~ \$LEO_LAYOUT_DIRECTION ~ "/footer.tpl" %}
</div>
EOF;
    }
}
