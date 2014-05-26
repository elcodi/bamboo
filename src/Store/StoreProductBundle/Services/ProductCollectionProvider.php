<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * This distribution is just a basic e-commerce implementation based on
 * Elcodi project.
 *
 * Feel free to edit it, and make your own
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Store\StoreProductBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\ProductBundle\Entity\Interfaces\CategoryInterface;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\ProductBundle\Services\ProductCollectionProvider as BaseProductCollectionProvider;

/**
 * Product Collection provider
 *
 * Locale is injected because we can just query products, loading at the same
 * time the corresponding translations.
 */
class ProductCollectionProvider extends BaseProductCollectionProvider
{
    /**
     * Given a specific Product, return a simple collection of related products
     *
     * @param ProductInterface $product Product
     * @param int              $limit   Limit
     *
     * @return ArrayCollection
     */
    public function getRelatedProducts(ProductInterface $product, $limit = 0)
    {
        $relatedProducts = new ArrayCollection();
        $principalCategory = $product->getPrincipalCategory();

        if ($principalCategory instanceof CategoryInterface) {

            $relatedProducts = $this
                ->productRepository
                ->findBy(array(
                    'principalCategory' => $product->getPrincipalCategory(),
                    'enabled'           => true
                ));

            $relatedProducts = array_slice($relatedProducts, 0, $limit);

            $relatedProducts = new ArrayCollection($relatedProducts);
            $relatedProducts->removeElement($product);

        }

        return $relatedProducts;
    }
}
