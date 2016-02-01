<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi.com
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

namespace Elcodi\Store\ProductBundle\Transformer;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslatorInterface;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Sitemap\Transformer\Interfaces\SitemapTransformerInterface;

/**
 * Class CategoryTransformer
 */
class CategoryTransformer implements SitemapTransformerInterface
{
    /**
     * @var EntityTranslatorInterface
     *
     * Entity Translator
     */
    protected $entityTranslator;

    /**
     * @var UrlGeneratorInterface
     *
     * Url generator
     */
    protected $router;

    /**
     * Construct
     *
     * @param EntityTranslatorInterface $entityTranslator Entity Translator
     * @param UrlGeneratorInterface     $router           Router
     */
    public function __construct(
        EntityTranslatorInterface $entityTranslator,
        UrlGeneratorInterface $router
    ) {
        $this->entityTranslator = $entityTranslator;
        $this->router = $router;
    }

    /**
     * Get url given an entity
     *
     * @param Mixed  $element  Element
     * @param string $language Language
     *
     * @return string url
     */
    public function getLoc($element, $language = null)
    {
        /**
         * @var CategoryInterface $element
         */
        if ($language) {
            $this->entityTranslator->translate(
                $element,
                $language
            );
        }

        return $this
            ->router
            ->generate('store_category_purchasables_list', [
                'id' => $element->getId(),
                'slug' => $element->getSlug(),
                '_locale' => $language,
            ], false);
    }

    /**
     * Get last mod
     *
     * @param Mixed  $element  Element
     * @param string $language Language
     *
     * @return string Last mod value
     */
    public function getLastMod($element, $language = null)
    {
        /**
         * @var CategoryInterface $element
         */
        return $element
            ->getUpdatedAt()
            ->format('c');
    }
}
