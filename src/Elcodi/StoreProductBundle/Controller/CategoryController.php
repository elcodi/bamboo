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

use Mmoreram\ControllerExtraBundle\Annotation\Entity as AnnotationEntity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;

/**
 * Category controller
 *
 * @Route(
 *      path = ""
 * )
 */
class CategoryController extends Controller
{
    /**
     * Renders the category nav component
     *
     * @return array Response parameters
     *
     * @Route(
     *      path = "/categories/nav",
     *      name = "store_categories_nav"
     * )
     * @Template
     */
    public function navAction()
    {
        $currentCategoryId = $this
            ->get('request_stack')
            ->getMasterRequest()
            ->get('id');

        $categoryTree = $this
            ->get('elcodi.core.product.service.category_manager')
            ->load();

        return [
            'currentCategoryId' => $currentCategoryId,
            'categoryTree' => $categoryTree,
        ];
    }

    /**
     * Render all category products
     *
     * @param CategoryInterface $category Category
     *
     * @return array Response parameters
     *
     * @Route(
     *      path = "category/{slug}/{id}",
     *      name = "store_category_products_list",
     *      requirements = {
     *          "slug" = "[a-zA-Z0-9-]+",
     *          "categoryId" = "\d+"
     *      }
     * )
     * @Template
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
        $products = $category->getProducts();

        return [
            'products' => $products,
            'category' => $category,
        ];
    }
}
