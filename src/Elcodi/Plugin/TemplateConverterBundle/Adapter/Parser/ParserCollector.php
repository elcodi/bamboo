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

use Elcodi\Plugin\TemplateConverterBundle\Adapter\Loader\ValueObject\FileCollector;
use Elcodi\Plugin\TemplateConverterBundle\Adapter\Parser\Abstracts\AbstractTemplateParser;
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Interfaces\TemplateTransformerInterface;

/**
 * Class ParserCollector
 */
class ParserCollector extends AbstractTemplateParser
{
    /**
     * @var AbstractTemplateParser[]
     *
     * Template parsers
     */
    private $templateParsers = [];

    /**
     * Add template parser
     *
     * @param AbstractTemplateParser $templateParser Template parser
     */
    public function addTemplateParser(AbstractTemplateParser $templateParser)
    {
        $this->templateParsers[] = $templateParser;
    }

    /**
     * Get Template Parsers
     *
     * @return AbstractTemplateParser[] Template parsers
     */
    public function getTemplateParsers()
    {
        return $this->templateParsers;
    }

    /**
     * Load data
     *
     * @param FileCollector $fileCollector File collector
     * @param TemplateTransformerInterface $templateTransformer Template Transformer
     *
     * @return string data to be saved
     */
    public function load(
        FileCollector $fileCollector,
        TemplateTransformerInterface $templateTransformer
    )
    {
        foreach ($this->templateParsers as $parser) {

            $parser->load(
                $fileCollector,
                $templateTransformer
            );
        }

        return;
    }

    /**
     * Get filename
     *
     * @return string Filename
     */
    public function getFilename()
    {

    }

    /**
     * Dump data
     *
     * @param string $newPath New path
     */
    public function dump($newPath)
    {
        foreach ($this->templateParsers as $parser) {

            $parser->dump($newPath);
        }
    }
}
