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
 
namespace Elcodi\Plugin\TemplateConverterBundle\Adapter\Parser;

use Elcodi\Plugin\TemplateConverterBundle\Exception\AdapterNotFoundException;

/**
 * Class ParserFactory
 */
class ParserFactory
{
    /**
     * Create a parser collector given the adapter name
     *
     * @param string $adapterName Adapter name
     *
     * @return ParserCollector Parser collector
     *
     * @throws AdapterNotFoundException Adapter not found
     */
    public function createParserCollectorByAdapterName($adapterName)
    {
        $adapterName = strtolower($adapterName);
        $adapterName = ucfirst($adapterName);
        $adapterNamespace = __NAMESPACE__ . '\\' . $adapterName;
        $layoutParserAdapter = $adapterNamespace . '\\Layout\\LayoutParser';

        if (!class_exists($layoutParserAdapter)) {

            throw new AdapterNotFoundException();
        }

        $parserCollector = new ParserCollector();
        $skeleton = [
            'Layout\\LayoutParser',
        ];

        foreach ($skeleton as $file) {
            $fileNamespace = $adapterNamespace . $file;
            $parserCollector->addTemplateParser(new $fileNamespace());
        }

        return new $adapterNamespace;
    }
}
