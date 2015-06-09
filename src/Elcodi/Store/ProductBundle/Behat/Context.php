<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Store\ProductBundle\Behat;

use Behat\Gherkin\Node\TableNode;
use Doctrine\ORM\EntityNotFoundException;
use Exception;

use Elcodi\Bridge\BehatBridgeBundle\Abstracts\AbstractElcodiContext;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;

/**
 * Class Context
 */
class Context extends AbstractElcodiContext
{
    /**
     * @Given ~^I am on the product (?P<productId>\d+) page$~
     */
    public function iAmOnTheProductPage($productId)
    {
        $product = $this->getProduct($productId);

        $this
            ->getSession()
            ->visit($this->getRoute('store_product_view', [
                'id' => $productId,
                'slug' => $product->getSlug(),
            ]));
    }

    /**
     * @Then ~^I should see more than (?P<numberOfProducts>\d+) products$~
     */
    public function iShouldSeeMoreThanXProducts($numberOfProducts)
    {
        $elements = $this->getItemElements();

        if (count($elements) <= $numberOfProducts) {
            throw new Exception(
                sprintf(
                    'Displayed %d products, minimum expected %d',
                    count($elements),
                    $numberOfProducts + 1
                )
            );
        }
    }

    /**
     * @Then ~^I should see less than (?P<numberOfProducts>\d+) products$~
     */
    public function iShouldSeeLessThanXProducts($numberOfProducts)
    {
        $elements = $this->getItemElements();

        if (count($elements) >= $numberOfProducts) {
            throw new Exception(
                sprintf(
                    'Displayed %d products, maximum expected %d',
                    count($elements),
                    $numberOfProducts - 1
                )
            );
        }
    }

    /**
     * @Then ~^I should see exactly (?P<numberOfProducts>\d+) products$~
     */
    public function iShouldSeeExactlyXProducts($numberOfProducts)
    {
        $elements = $this->getItemElements();

        if (count($elements) != $numberOfProducts) {
            throw new Exception(
                sprintf(
                    'Displayed %d products, expected %d',
                    count($elements),
                    $numberOfProducts
                )
            );
        }
    }

    /**
     * @Then ~^I should see product (?P<productId>\d+) name$~
     */
    public function iShouldSeeProductName($productId)
    {
        $product = $this->getProduct($productId);

        $elements = $this
            ->getSession()
            ->getPage()
            ->findAll('xpath', '//h1[contains(., "' . $product->getName() . '")]');

        if (count($elements) != 1) {
            throw new Exception(
                sprintf(
                    'Product with id %d found %d times. expected 1',
                    $product->getId(),
                    count($elements)
                )
            );
        }
    }

    /**
     * @Then ~^I should see category menu item$~
     */
    public function iShouldSeeCategoryMenuItem(TableNode $table)
    {
        foreach ($table as $node) {
            $categoryName = $node['name'];
            $active = $node['active'];

            $activeXpath = $active == 'true'
                ? 'a[contains(@class, "active")]'
                : 'a[not(contains(@class, "active"))]';

            $element = $this
                ->getSession()
                ->getPage()
                ->find(
                    'xpath',
                    '//ul[contains(@class, "category-nav")]/li/' . $activeXpath . '[contains(text(), "' . $categoryName . '")]'
                );

            if (is_null($element)) {
                $activeExpression = $active
                    ? 'active'
                    : 'non active';

                throw new Exception(
                    sprintf(
                        'Category with name "%s" not found as a %s root menu',
                        $categoryName,
                        $activeExpression
                    )
                );
            }
        }
    }

    /**
     * Get product by id
     *
     * @param integer $productId Product Id
     *
     * @return ProductInterface Product
     *
     * @throws EntityNotFoundException Product not found
     */
    protected function getProduct($productId)
    {
        $product = $this
            ->getContainer()
            ->get('elcodi.provider.repository')
            ->getRepositoryByEntityParameter('elcodi.entity.product.class')
            ->find($productId);

        if (!($product instanceof ProductInterface)) {
            throw new EntityNotFoundException(
                sprintf(
                    'Product with id %d was not found',
                    $productId
                )
            );
        }

        return $product;
    }

    /**
     * Get category by id
     *
     * @param integer $categoryId Category Id
     *
     * @return CategoryInterface Category
     *
     * @throws EntityNotFoundException Category not found
     */
    protected function getCategory($categoryId)
    {
        $category = $this
            ->getContainer()
            ->get('elcodi.provider.repository')
            ->getRepositoryByEntityParameter('elcodi.entity.category.class')
            ->find($categoryId);

        if (!($category instanceof ProductInterface)) {
            throw new EntityNotFoundException(
                sprintf(
                    'Category with id %d was not found',
                    $categoryId
                )
            );
        }

        return $category;
    }

    /**
     * @return \Behat\Mink\Element\NodeElement[]
     */
    protected function getItemElements()
    {
        $elements = $this
            ->getSession()
            ->getPage()
            ->findAll('xpath', '//div[contains(@class, "product-item")]');

        return $elements;
    }
}
