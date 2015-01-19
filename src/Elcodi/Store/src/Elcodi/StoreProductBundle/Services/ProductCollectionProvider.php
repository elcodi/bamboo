<?php

/**
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
 */

namespace Elcodi\StoreProductBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Services\ProductCollectionProvider as BaseProductCollectionProvider;

/**
 * Product Collection provider
 *
 * Locale is injected because we can just query products, loading at the same
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
    public function getRelatedProducts(ProductInterface $product, $limit)
    {
        $relatedProducts = new ArrayCollection();
        $principalCategory = $product->getPrincipalCategory();

        if ($principalCategory instanceof CategoryInterface) {

            $relatedProducts = $this
                ->productRepository
                ->createQueryBuilder('p')
                ->select('p', 'v', 'o')
                ->leftJoin('p.variants', 'v')
                ->leftJoin('v.options', 'o')
                ->where('p.principalCategory = :principalCategory')
                ->andWhere('p.enabled = :enabled')
                ->setParameters([
                    'principalCategory' => $principalCategory,
                    'enabled' => true
                ])
                ->getQuery()
                ->getResult();

            $relatedProducts = new ArrayCollection($relatedProducts);
            $relatedProducts->removeElement($product);
            $relatedProducts = $relatedProducts->slice(0, $limit);
        }

        return $relatedProducts;
    }
}
