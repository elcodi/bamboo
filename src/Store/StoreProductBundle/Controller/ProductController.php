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

use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as AnnotationEntity;

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
     * @param ProductInterface $product Product
     *
     * @return array
     *
     * @Route(
     *      path = "/product/{slug}/{id}",
     *      name = "store_product_view",
     *      requirements = {
     *          "slug": "[\w-]+",
     *          "productId": "\d+",
     *      }
     * )
     * @Template
     *
     * @AnnotationEntity(
     *      class = "elcodi.core.product.entity.product.class",
     *      name = "product",
     *      mapping = {
     *          "id" = "~id~",
     *          "enabled" = true,
     *      }
     * )
     */
    public function viewAction(ProductInterface $product)
    {
        $relatedProducts = $this
            ->get('store.product.service.product_collection_provider')
            ->getRelatedProducts($product, 3);

        return [
            'product'          => $product,
            'related_products' => $relatedProducts
        ];
    }
}
