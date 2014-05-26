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

namespace Store\StoreProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Elcodi\ProductBundle\Entity\Interfaces\CategoryInterface;

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
     * @param int  $productId  Product id
     * @param null $cartLineId
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
     */
    public function viewAction($productId, $cartLineId = null)
    {

        $productEntityNamespace = $this
            ->container
            ->getParameter('elcodi.core.product.entity.product.class');

        $relatedProducts = [];

        $product = $this->getDoctrine()->getRepository('ElcodiProductBundle:Product')->find($productId);

        return array(
            'product'          => $product,
            'related_products' => $this->get('store.product.service.product_collection_provider')
               ->getRelatedProducts($product)
        );
    }
}
