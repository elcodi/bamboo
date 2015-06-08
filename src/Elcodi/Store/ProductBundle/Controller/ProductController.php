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

namespace Elcodi\Store\ProductBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as AnnotationEntity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Store\CoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Product related actions
 *
 * @Route(
 *      path = "/product"
 * )
 */
class ProductController extends Controller
{
    use TemplateRenderTrait;

    /**
     * Product view
     *
     * @param ProductInterface $product Product
     * @param string           $slug    Product slug
     *
     * @return array
     *
     * @Route(
     *      path = "/{slug}/{id}",
     *      name = "store_product_view",
     *      requirements = {
     *          "slug": "[\w-]+",
     *          "id": "\d+",
     *      },
     *      methods = {"GET"}
     * )
     *
     * @AnnotationEntity(
     *      class = "elcodi.entity.product.class",
     *      name = "product",
     *      mapping = {
     *          "id" = "~id~",
     *          "enabled" = true,
     *      }
     * )
     */
    public function viewAction(ProductInterface $product, $slug)
    {
        /**
         * We must check that the product slug is right. Otherwise we must
         * return a Redirection 301 to the right url
         */
        if ($slug !== $product->getSlug()) {
            return $this->redirectToRoute('store_product_view', [
                'id'   => $product->getId(),
                'slug' => $product->getSlug(),
            ], 301);
        }

        $useStock = $this
            ->get('elcodi.store')
            ->getUseStock();

        $relatedProducts = $this
            ->get('elcodi_store.provider.product_collection')
            ->getRelatedProducts($product, 3);

        $template = $product->hasVariants()
            ? 'Pages:product-view-variant.html.twig'
            : 'Pages:product-view-item.html.twig';

        return $this->renderTemplate($template, [
            'product'          => $product,
            'related_products' => $relatedProducts,
            'useStock'         => $useStock,
        ]);
    }
}
