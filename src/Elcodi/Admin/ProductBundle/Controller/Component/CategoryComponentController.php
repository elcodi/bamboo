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
 */

namespace Elcodi\Admin\ProductBundle\Controller\Component;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Elcodi\Component\Product\Entity\Category;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Paginator as PaginatorAnnotation;
use Mmoreram\ControllerExtraBundle\ValueObject\PaginatorAttributes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormView;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;

/**
 * Class CategoryComponentController
 */
class CategoryComponentController extends AbstractAdminController
{
    /**
     * Component for entity list.
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/list/component",
     *      name = "admin_category_list_component"
     * )
     * @Template("AdminProductBundle:Category:listComponent.html.twig")
     * @Method({"GET"})
     */
    public function listComponentAction()
    {
        $category_manager = $this->get('elcodi.category_tree');
        $category_tree   = $category_manager->buildCategoryTree();

        return ['categories_list' => $category_tree];
    }

    /**
     * New element component action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param FormView          $formView Form view
     * @param CategoryInterface $category Category
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/component",
     *      name = "admin_category_edit_component",
     *      requirements = {
     *          "id" = "\d+",
     *      }
     * )
     * @Route(
     *      path = "/new/component",
     *      name = "admin_category_new_component",
     *      methods = {"GET"}
     * )
     * @Template("AdminProductBundle:Category:editComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.category",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      name = "category",
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_product_form_type_category",
     *      name  = "formView",
     *      entity = "category",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function editComponentAction(
        FormView $formView,
        CategoryInterface $category
    )
    {
        return [
            'category' => $category,
            'form'     => $formView,
        ];
    }
}
