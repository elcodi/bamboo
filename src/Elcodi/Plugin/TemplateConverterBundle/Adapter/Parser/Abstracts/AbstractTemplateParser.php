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
        $fileName = $newPath . $this->getFilename();
        $dir = dirname($fileName);

        if (!is_dir($dir)) {
            mkdir($dir);
        }

        file_put_contents(
            $newPath . $this->getFilename(),
            $this->content
        );
    }

    /**
     * Get skeleton file
     *
     * @param string $fileName  Skeleton file name
     * @param array  $variables Variable to replace
     *
     * @return string File content
     */
    protected function getSkeletonFileContent($fileName, $variables = [])
    {
        $newVariables = [];
        foreach ($variables as $variableName => $variableValue) {

            $newVariables['{-- ' . $variableName . ' --}'] = $variableValue;
        }

        $base = file_get_contents(
            dirname(__FILE__) . '/../Skeleton/' . $fileName . '.html.twig'
        );

        return str_replace(
            array_keys($newVariables),
            array_values($newVariables),
            $base
        );
    }

    /**
     * Convert and save a file locally
     *
     * @param FileCollector                $fileCollector       File collector
     * @param TemplateTransformerInterface $templateTransformer Template Transformer
     * @param string                       $fileName            File name
     */
    protected function convertAndSaveFile
    (
        FileCollector $fileCollector,
        TemplateTransformerInterface $templateTransformer,
        $fileName
    )
    {
        $data = $fileCollector
            ->getFileByName($fileName)
            ->getData();
        $regexForCapturing = $templateTransformer->getCapturer()->getRegexForCapturing();
        preg_match_all(
            $regexForCapturing,
            $data,
            $matches
        );

        $equivalences = [];
        foreach ($matches[0] as $match) {
            $equivalences[$match] = $templateTransformer->toTwig($match);
        }

        $this->content = str_replace(
            array_keys($equivalences),
            array_values($equivalences),
            $data
        );
    }
}
