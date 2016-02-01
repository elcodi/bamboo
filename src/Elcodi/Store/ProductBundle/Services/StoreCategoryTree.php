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

namespace Elcodi\Store\ProductBundle\Services;

use Elcodi\Component\Core\Wrapper\Abstracts\AbstractCacheWrapper;
use Elcodi\Component\Language\Entity\Interfaces\LocaleInterface;
use Elcodi\Component\Product\Entity\Category;
use Elcodi\Component\Product\Services\CategoryTree;

/**
 * Class StoreCategoryTree
 */
class StoreCategoryTree extends AbstractCacheWrapper
{
    /**
     * @var array|null
     *
     * The store category tree.
     */
    private $storeCategoryTree;

    /**
     * @var boolean
     *
     * Load only categories with products
     */
    private $loadOnlyCategoriesWithProducts;

    /**
     * @var string
     *
     * Cache key
     */
    private $key;

    /**
     * @var CategoryTree
     *
     * The category tree service to generate the full category tree
     */
    private $categoryTreeService;

    /**
     * @var LocaleInterface
     *
     * Locale in which the categories are stored
     */
    protected $locale;

    /**
     * Construct method
     *
     * @param CategoryTree    $categoryTreeService            The category tree service
     * @param boolean         $loadOnlyCategoriesWithProducts Load only categories with products
     * @param string          $key                            Key where to store info
     * @param LocaleInterface $locale                         Locale of the categories
     */
    public function __construct(
        CategoryTree $categoryTreeService,
        $loadOnlyCategoriesWithProducts,
        $key,
        LocaleInterface $locale
    ) {
        $this->categoryTreeService            = $categoryTreeService;
        $this->loadOnlyCategoriesWithProducts = $loadOnlyCategoriesWithProducts;
        $this->key                            = $key;
        $this->locale                         = $locale;
    }

    /**
     * Get category tree
     *
     * @return array Category tree
     */
    public function getStoreCategoryTree()
    {
        return $this->storeCategoryTree;
    }

    /**
     * Load Category tree from cache.
     *
     * If element is not loaded yet, loads it from Database and store it into
     * cache.
     *
     * @return array Category tree loaded
     */
    public function load()
    {
        if (is_array($this->storeCategoryTree)) {
            return $this->storeCategoryTree;
        }

        /**
         * Fetch key from cache
         */
        $storeCategoryTree = $this->loadCategoryTreeFromCache();

        /**
         * If cache key is empty, build it
         */
        if (is_null($storeCategoryTree)) {
            $storeCategoryTree = $this->buildCategoryTreeAndSaveIntoCache();
        }

        $this->storeCategoryTree = $storeCategoryTree;

        return $storeCategoryTree;
    }

    /**
     * Reload Category tree from cache
     *
     * Empty cache and load again
     *
     * @return array Category tree loaded
     */
    public function reload()
    {
        $this
            ->cache
            ->delete($this->getKey());

        $this->storeCategoryTree = null;

        return $this->load();
    }

    /**
     * Load category tree from cache
     *
     * @return array Category tree
     */
    protected function loadCategoryTreeFromCache()
    {
        return $this
            ->encoder
            ->decode(
                $this
                    ->cache
                    ->fetch($this->getKey())
            );
    }

    /**
     * Build category tree and save it into cache
     *
     * @return array Category tree
     */
    protected function buildCategoryTreeAndSaveIntoCache()
    {
        $categoryTree = $this->buildStoreCategoryTree();
        $this->saveCategoryTreeIntoCache($categoryTree);

        return $categoryTree;
    }

    /**
     * Save given category tree into cache
     *
     * @param array $categoryTree Category tree
     *
     * @return $this Self object
     */
    protected function saveCategoryTreeIntoCache($categoryTree)
    {
        $this
            ->cache
            ->save(
                $this->getKey(),
                $this->encoder->encode($categoryTree)
            );

        return $this;
    }

    /**
     * Build the store category tree (Can change depending on categories enabled and store config).
     *
     * @return Array Category tree
     */
    protected function buildStoreCategoryTree()
    {
        $categoryTree = $this->categoryTreeService->buildCategoryTree();

        return $this->formatCategoryTree($categoryTree);
    }

    /**
     * Formats a category tree to return it on a store friendly format.
     *
     * @param array $categoryTree The categories tree.
     *
     * @return array The formatted category tree
     */
    protected function formatCategoryTree(array &$categoryTree)
    {
        $formattedCategoryTree = [];
        foreach ($categoryTree as $categoryNode) {
            if ($this->isCategoryEnabled($categoryNode['entity'])) {
                $formattedCategoryTree[] = $this->formatCategoryNode($categoryNode);
            }
        }

        return $formattedCategoryTree;
    }

    /**
     * Formats a category node form a category tree to return it on a store friendly format.
     * A node is supposed to have an entity and a children key.
     *
     * @param array $categoryNode The category node to format
     *
     * @return array The formatted category node.
     */
    protected function formatCategoryNode(array $categoryNode)
    {
        $formatted_node = [
            'entity'   => [
                'id'            => $categoryNode['entity']->getId(),
                'name'          => $categoryNode['entity']->getName(),
                'slug'          => $categoryNode['entity']->getSlug(),
                'productsCount' => count($categoryNode['entity']->getPurchasables()),
            ],
            'children' => empty($categoryNode['children'])
                ? []
                : $this->formatCategoryTree($categoryNode['children']),
        ];

        return $formatted_node;
    }

    /**
     * Checks if a category is enabled. A category can be disabled by itself or by other store configurations like
     * the options to only load categories with products.
     *
     * @param Category $category The category to check.
     *
     * @return bool If the category is enabled and should be showed on the categories tree.
     */
    protected function isCategoryEnabled(Category $category)
    {
        return
            $category->isEnabled() &&
            (
                !$this->loadOnlyCategoriesWithProducts ||
                0 > ($category->getProducts())
            );
    }

    /**
     * Get current key
     */
    protected function getKey()
    {
        return "{$this->key}_{$this->locale->getIso()}";
    }
}
