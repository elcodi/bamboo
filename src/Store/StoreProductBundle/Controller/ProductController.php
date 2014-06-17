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

namespace Store\StoreProductBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Product related actions
 *
 * @Route(
 *      path = ""
 * )
 */
class ProductController extends Controller
{
    /**
     * Product view
     *
     * @param int $productId Product id
     *
     * @return array
     *
     * @Route(
     *      path = "/product/{slug}/{productId}",
     *      name = "store_product_view",
     *      requirements = {
     *          "slug": "[\w-]+",
     *          "productId": "\d+",
     *      }
     * )
     * @Template
     *
     * @throws EntityNotFoundException Product not found
     */
    public function viewAction($productId)
    {
        $product = $this
            ->get('elcodi.repository.product')
            ->find($productId);

        if (!($product instanceof ProductInterface)) {

            throw new EntityNotFoundException($this
                ->container
                ->getParameter('elcodi.core.product.entity.product.class'));
        }

        $relatedProducts = $this
                ->get('store.product.service.product_collection_provider')
                ->getRelatedProducts($product, 3);

        return array(
            'product'          => $product,
            'related_products' => $relatedProducts
        );
    }
}
