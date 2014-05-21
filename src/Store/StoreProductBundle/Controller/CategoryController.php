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

use Doctrine\ORM\EntityNotFoundException;
use Elcodi\ProductBundle\Entity\Category;
use Elcodi\ProductBundle\Entity\Interfaces\CategoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        return [
            'category_tree' => $this->get('elcodi.core.product.services.category_manager')->getCategoryTree(),
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
     *      path = "/{slug}/{categoryId}/c",
     *      name = "store_category_products_list",
     *      requirements = {
     *          "slug" = "[a-zA-Z0-9-]+",
     *          "categoryId" = "\d+"
     *      }
     * )
     *
     * @throws EntityNotFoundException Entity not found
     * @Template
     */
    public function listAction($categoryId)
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
