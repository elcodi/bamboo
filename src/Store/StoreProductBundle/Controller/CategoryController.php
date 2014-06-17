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

namespace Store\StoreProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Elcodi\ProductBundle\Entity\Interfaces\CategoryInterface;

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
            ->get('categoryId');

        $categoryTree = $this
            ->get('elcodi.core.product.service.category_manager')
            ->getCategoryTree();

        return [
            'currentCategoryId' => $currentCategoryId,
            'categoryTree' => $categoryTree,
        ];
    }

    /**
     * Render all category products
     *
     * @param integer $categoryId Category id
     *
     * @return array Response parameters
     *
     * @Route(
     *      path = "category/{slug}/{categoryId}",
     *      name = "store_category_products_list",
     *      requirements = {
     *          "slug" = "[a-zA-Z0-9-]+",
     *          "categoryId" = "\d+"
     *      }
     * )
     * @Template
     *
     * @throws EntityNotFoundException Entity not found
     */
    public function viewAction($categoryId)
    {
        $categoryEntityNamespace = $this
            ->container
            ->getParameter('elcodi.core.product.entity.category.class');

        $category = $this
            ->get('doctrine.orm.entity_manager')
            ->getRepository($categoryEntityNamespace)
            ->findOneBy(array(
                'id'    =>  $categoryId,
                'enabled'   =>  true
            ));

        if (!($category instanceof CategoryInterface)) {

            throw new EntityNotFoundException($categoryEntityNamespace);
        }

        $products = $category->getProducts();

        return [
            'products' => $products,
            'category' => $category,
        ];
    }
}
