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

namespace Elcodi\Plugin\TemplateConverterBundle\Adapter\Parser\Prestashop\Layout;

use Elcodi\Plugin\TemplateConverterBundle\Adapter\Loader\ValueObject\FileCollector;
use Elcodi\Plugin\TemplateConverterBundle\Adapter\Parser\Abstracts\AbstractTemplateParser;
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Interfaces\TemplateTransformerInterface;

/**
 * Class LayoutParser
 */
class LayoutParser extends AbstractTemplateParser
{
    /**
     * Load data
     *
     * @param FileCollector                $fileCollector       File collector
     * @param TemplateTransformerInterface $templateTransformer Template Transformer
     */
    public function load(
        FileCollector $fileCollector,
        TemplateTransformerInterface $templateTransformer
    )
    {
        // TODO: Implement load() method.
    }

    /**
     * Get filename
     *
     * @return string Filename
     */
    public function getFilename()
    {
        return 'Layout/_layout.html.twig';
    }
}
