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

namespace Elcodi\Store\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Store\CoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Home controller
 *
 * This class should only contain home actions
 */
class HomeController extends Controller
{
    use TemplateRenderTrait;

    /**
     * Home page.
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/",
     *      name = "store_homepage",
     *      methods = {"GET"}
     * )
     */
    public function homeAction()
    {
        $productCollectionProvider = $this
            ->container
            ->get('store.product.service.product_collection_provider');

        $products = $productCollectionProvider->getHomeProducts();

        return $this->renderTemplate(
            'Pages:home-view.html.twig',
            [
                'products' => $products,
            ]
        );
    }
}
