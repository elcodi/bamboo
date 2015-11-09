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
 
namespace Elcodi\Plugin\TemplateConverterBundle\Adapter\Parser\Abstracts;

use Elcodi\Plugin\TemplateConverterBundle\Adapter\Loader\ValueObject\FileCollector;
use Elcodi\Plugin\TemplateConverterBundle\Transformer\Interfaces\TemplateTransformerInterface;

/**
 * Class AbstractTemplateParser
 */
abstract class AbstractTemplateParser
{
    /**
     * @var string
     *
     * Content
     */
    protected $content;

    /**
     * Load data
     *
     * @param FileCollector                $fileCollector       File collector
     * @param TemplateTransformerInterface $templateTransformer Template Transformer
     */
    abstract public function load(
        FileCollector $fileCollector,
        TemplateTransformerInterface $templateTransformer
    );

    /**
     * Get filename
     *
     * @return string Filename
     */
    abstract public function getFilename();

    /**
     * Dump data
     *
     * @param string $newPath New path
     */
    public function dump($newPath)
    {
        file_put_contents(
            $newPath . '/' . $this->getFilename(),
            $this->content
        );
    }
}
