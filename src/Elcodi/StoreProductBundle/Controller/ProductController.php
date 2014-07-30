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

namespace Elcodi\StoreProductBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as AnnotationEntity;
use Mmoreram\ControllerExtraBundle\Annotation\JsonResponse;

use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\ProductBundle\Entity\Interfaces\VariantInterface;
use Elcodi\ProductBundle\Twig\ProductExtension;

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

        $viewParameters = array(
            'product'          => $product,
            'related_products' => $relatedProducts
        );

        if ($product->hasVariants()) {
            $templateName = 'StoreProductBundle:Product:viewVariant.html.twig';
        } else {
            $templateName = 'StoreProductBundle:Product:view.html.twig';
        }

        return $this->render($templateName, $viewParameters);
    }

    /**
     * @param Request          $request
     * @param ProductInterface $product
     *
     * @return array
     *
     * @Route(
     *      path = "/variant/product/{id}",
     *      name = "store_product_variant_info",
     *      requirements = {
     *          "id": "\d+",
     *      }
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
    public function variantInfoAction(Request $request, ProductInterface $product)
    {
        $optionIds = $request->query->get('variant-option-for-attribute');

        $variant = $this
            ->get('elcodi.repository.variant')
            ->findByOptionIds($product, $optionIds);

        if (!$variant instanceof VariantInterface) {
            return [
                'id'         => null,
                'name'       => null,
                'parentName' => $variant->getProduct()->getName(),
                'price'      => null
            ];
        }

        $variantName = (new ProductExtension())->getPurchasableName($variant);
        $variantPrice = $this
            ->get('elcodi.core.currency.twig_extension.print_money')
            ->printConvertMoney($variant->getPrice());

        return [
            'id'    => $variant->getId(),
            'name'  => $variantName,
            'price' => $variantPrice
        ];
    }

}
