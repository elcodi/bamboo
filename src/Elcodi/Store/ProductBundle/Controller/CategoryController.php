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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Store\CoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Category controller
 *
 * @Route(
 *      path = ""
 * )
 */
class CategoryController extends Controller
{
    use TemplateRenderTrait;

    /**
     * Renders the category nav component
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/categories/nav",
     *      name = "store_categories_nav",
     *      methods = {"GET"}
     * )
     */
    public function navAction()
    {
        $masterRequest = $this
            ->get('request_stack')
            ->getMasterRequest();

        $currentCategory = $this->getCurrentCategoryGivenRequest($masterRequest);

        $categoryTree = $this
            ->get('store.product.service.store_category_tree')
            ->load();

        return $this->renderTemplate(
            'Subpages:category-nav.html.twig',
            [
                'currentCategory' => $currentCategory,
                'categoryTree'    => $categoryTree,
            ]
        );
    }

    /**
     * Render all category products
     *
     * @param CategoryInterface $category Category
     *
     * @return Response Response
     *
     * @Route(
     *      path = "category/{slug}/{id}",
     *      name = "store_category_products_list",
     *      requirements = {
     *          "slug" = "[a-zA-Z0-9-]+",
     *          "id" = "\d+"
     *      },
     *      methods = {"GET"}
     * )
     *
     * @AnnotationEntity(
     *      class = "elcodi.core.product.entity.category.class",
     *      name = "category",
     *      mapping = {
     *          "id" = "~id~",
     *          "enabled" = true,
     *      }
     * )
     */
    public function viewAction(CategoryInterface $category)
    {
        $products = $this
            ->get('elcodi.repository.product')
            ->findBy([
                'principalCategory' => $category,
                'enabled'           => true,
            ]);

        return $this->renderTemplate(
            'Pages:category-view.html.twig',
            [
                'products' => $products,
                'category' => $category,
            ]
        );
    }

    /**
     * Given a request, return the current highlight-able category
     *
     * @param Request $request Request
     *
     * @return CategoryInterface|null
     */
    protected function getCurrentCategoryGivenRequest(Request $request)
    {
        $masterRoute = $request->get('_route');
        $category = null;

        if ($masterRoute === 'store_product_view') {
            $productId = $request->get('id');
            $productRepository = $this->get('elcodi.repository.product');
            $product = $productRepository->find($productId);
            $category = $product->getPrincipalCategory();
        } elseif ($masterRoute === 'store_category_products_list') {
            $categoryId = $request->get('id');
            $categoryRepository = $this->get('elcodi.repository.category');
            $category = $categoryRepository->find($categoryId);
        }

        return $category;
    }
}
