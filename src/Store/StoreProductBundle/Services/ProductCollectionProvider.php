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
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Store\StoreProductBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\ProductBundle\Repository\ProductRepository;

/**
 * Product Collection provider
 *
 * Locale is injected because we can just query products, loading at the same
 * time the corresponding translations.
 */
class ProductCollectionProvider
{

    /**
     * @var ProductRepository
     *
     * Product Repository
     */
    private $productRepository;

    /**
     * Construct method
     *
     * @param ProductRepository $productRepository Product Repository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Get products that can be shown in Home.
     * All products returned are actived and none deleted
     *
     * @param integer $limit Product limit. By default, this value is 0
     *
     * @return ArrayCollection Set of products, result of the query
     */
    public function getHomeProducts($limit = 0)
    {
        $query = $this
            ->productRepository
            ->createQueryBuilder('p')
            ->where('p.enabled = :enabled')
            ->setParameters([
                'enabled' => true,
            ])
            ->orderBy('p.updatedAt', 'DESC');

        if ($limit > 0) {

            $query->setMaxResults($limit);
        }

        $results = $query
            ->getQuery()
            ->getResult();

        return new ArrayCollection($results);
    }

    /**
     * Get products with price reduction.
     * All products returned are actived and none deleted
     *
     * @param integer $limit Product limit. By default, this value is 0
     *
     * @return ArrayCollection Set of products, result of the query
     */
    public function getOfferProducts($limit = 0)
    {
        $query = $this
            ->productRepository
            ->createQueryBuilder('p')
            ->where('p.enabled = :enabled')
            ->setParameters([
                'enabled' => true,
            ])
            ->orderBy('p.updatedAt', 'DESC');

        if ($limit > 0) {

            $query->setMaxResults($limit);
        }

        $results = $query
            ->getQuery()
            ->getResult();

        return new ArrayCollection($results);
    }
}
