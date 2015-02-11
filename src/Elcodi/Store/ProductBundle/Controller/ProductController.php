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

namespace Elcodi\Store\ProductBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as AnnotationEntity;
use Mmoreram\ControllerExtraBundle\Annotation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;
use Elcodi\Component\Product\Twig\ProductExtension;
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

        $template = $product->hasVariants()
            ? 'Pages:product-view-variant.html.twig'
            : 'Pages:product-view-item.html.twig';

        return $this->renderTemplate($template, [
            'product'          => $product,
            'related_products' => $relatedProducts,
        ]);
    }

    /**
     * @param Request          $request
     * @param ProductInterface $product
     *
     * @return array
     *
     * @Route(
     *      path = "/{id}/variant",
     *      name = "store_product_variant_info",
     *      requirements = {
     *          "id": "\d+",
     *      },
     *      methods = {"GET"}
     * )
     *
     * @AnnotationEntity(
     *      class = "elcodi.core.product.entity.product.class",
     *      name = "product",
     *      mapping = {
     *          "id" = "~id~",
     *          "enabled" = true,
     *      }
     * )
     *
     * @JsonResponse()
     */
    public function variantInfoAction(
        Request $request,
        ProductInterface $product
    ) {
        $optionIds = $request
            ->query
            ->get('variant-option-for-attribute');

        $variant = $this
            ->get('elcodi.repository.product_variant')
            ->findByOptionIds($product, $optionIds);

        if (!($variant instanceof VariantInterface)) {
            return [
                'id'         => null,
                'name'       => null,
                'parentName' => $product->getName(),
                'price'      => null,
            ];
        }

        $variantName = (new ProductExtension())->getPurchasableName($variant);
        $variantPrice = $this
            ->get('elcodi.core.currency.twig_extension.print_money')
            ->printConvertMoney($variant->getPrice());

        return [
            'id'    => $variant->getId(),
            'name'  => $variantName,
            'price' => $variantPrice,
        ];
    }
}
