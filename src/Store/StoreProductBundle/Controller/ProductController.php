<?php

/**
 * This file is part of the Controller Extra Bundle
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @since 2013
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Store\StoreProductBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Elcodi\ProductBundle\Entity\Interfaces\CategoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Elcodi\ProductBundle\Entity\Product;
use Elcodi\CartBundle\Entity\CartLine;

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
     * @param null $cartLineId
     *
     * @return array
     *
     * @Route(
     *      path = "/{slug}/{productId}/p",
     *      name = "store_product_view",
     *      requirements = {
     *          "slug": "[\w-]+",
     *          "productId": "\d+",
     *      }
     * )
     * @Route(
     *      path = "/{productId}/line/{cartlineId}/p",
     *      name = "store_product_view_cartline"
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

        $principalCategory = $product->getPrincipalCategory();
        if ($principalCategory instanceof CategoryInterface) {

            $relatedProducts = $this
                ->getDoctrine()
                ->getRepository($productEntityNamespace)
                ->findBy(array(
                    'principalCategory' =>  $principalCategory,
                    'enabled' => true
                ));

            $relatedProducts = new ArrayCollection($relatedProducts);

            $relatedProducts->removeElement($product);
        }

        return array(
            'product'          => $product,
            'related_products' => $relatedProducts
        );
    }
}
