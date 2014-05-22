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
    public function homeAction()
    {
        $productCollectionProvider = $this
            ->container
            ->get('store.product.services.product_collection_provider');

        $products = $productCollectionProvider->getHomeProducts();

        return array(
            'products' => $products,
        );

        return [];
    }
}
