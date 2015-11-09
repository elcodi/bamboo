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

namespace Elcodi\Plugin\TemplateConverterBundle\Converter;

use Elcodi\Plugin\TemplateConverterBundle\Adapter\Detector\DetectorCollection;
use Elcodi\Plugin\TemplateConverterBundle\Adapter\Detector\PrestashopDetector;
use Elcodi\Plugin\TemplateConverterBundle\Adapter\Detector\Interfaces\DetectorInterface;
use Elcodi\Plugin\TemplateConverterBundle\Adapter\Loader\LoaderFactory;
use Elcodi\Plugin\TemplateConverterBundle\Adapter\Parser\ParserFactory;
use Elcodi\Plugin\TemplateConverterBundle\Transformer\TemplateTransformerFactory;

/**
 * Class TemplateConverter
 */
class TemplateConverter
{
    /**
     * @var LoaderFactory
     *
     * Loader factory
     */
    private $loaderFactory;

    /**
     * @var ParserFactory
     *
     * Parser factory
     */
    private $parserFactory;

    /**
     * @var TemplateTransformerFactory
     *
     * Template transformer factory
     */
    private $templateTransformerFactory;

    /**
     * Constructor
     *
     * @param LoaderFactory              $loaderFactory              Loader Factory
     * @param ParserFactory              $parserFactory              Parser Factory
     * @param TemplateTransformerFactory $templateTransformerFactory Template Transformer Factory
     */
    function __construct(
        LoaderFactory $loaderFactory,
        ParserFactory $parserFactory,
        TemplateTransformerFactory $templateTransformerFactory
    )
    {
        $this->loaderFactory = $loaderFactory;
        $this->parserFactory = $parserFactory;
        $this->templateTransformerFactory = $templateTransformerFactory;
    }


    /**
     * Convert given a path
     *
     * @param string $projectPath Project path
     * @param string $newPath     New path
     *
     * @return boolean Template converted properly
     */
    public function convertFromProjectPath(
        $projectPath,
        $newPath
    )
    {
        $detectorCollection = new DetectorCollection();
        $detectorCollection->addDetector(new PrestashopDetector());
        $detector = $detectorCollection->getValidDetectorByProjectPath($projectPath);

        if (!($detector instanceof DetectorInterface)) {

            return false;
        }

        $adapterName = $detector->getAdapterName();
        $engineName = $detector->getEngineName();
        $loader = $this
            ->loaderFactory
            ->createLoaderByAdapterName($adapterName);

        $templateTransformer = $this
            ->templateTransformerFactory
            ->createTemplateTransformerByEngineName($engineName);

        $fileCollection = $loader->loadProject($projectPath);
        $parserCollection = $this
            ->parserFactory
            ->createParserCollectorByAdapterName($adapterName);

        $parserCollection->load($fileCollection, $templateTransformer);
        $parserCollection->dump($newPath);

        return true;
    }
}
