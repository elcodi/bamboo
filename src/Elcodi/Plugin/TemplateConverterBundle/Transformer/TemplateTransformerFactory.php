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
 
namespace Elcodi\Plugin\TemplateConverterBundle\Transformer;
use Elcodi\Plugin\TemplateConverterBundle\Exception\EngineNotFoundException;
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Interfaces\TemplateTransformerInterface;

/**
 * Class TemplateTransformerFactory
 */
class TemplateTransformerFactory
{
    /**
     * Create transformer by engine name
     *
     * @param string $engineName Engine name
     *
     * @return TemplateTransformerInterface Transformer
     *
     * @throws EngineNotFoundException Engine not found
     */
    public function createTemplateTransformerByEngineName($engineName)
    {
        $engineName = strtolower($engineName);
        $engineName = ucfirst($engineName);
        $templateTransformerNamespace = __NAMESPACE__ . '\\' . $engineName . '\\TemplateTransformer';

        if (!class_exists($templateTransformerNamespace)) {

            throw new EngineNotFoundException();
        }

        return new $templateTransformerNamespace();
    }
}
