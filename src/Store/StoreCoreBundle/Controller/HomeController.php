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

namespace Store\StoreCoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Home controller
 *
 * This class should only contain home actions
 */
class HomeController extends Controller
{
    /**
     * Home page.
     *
     * @return array
     *
     * @Route(
     *      path = "/",
     *      name = "store_homepage"
     * )
     * @Template
     */
    public function indexAction()
    {
        $productCollectionProvider = $this
            ->container
            ->get('store.product.services.product_collection_provider');

        $products = $productCollectionProvider->getHomeProducts($limit);

        return array(
            'products'   => $products,
        );
    }
}
