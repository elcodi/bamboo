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

namespace Elcodi\AdminProductBundle\Controller\Component;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Paginator as PaginatorAnnotation;
use Mmoreram\ControllerExtraBundle\ValueObject\PaginatorAttributes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormView;

use Elcodi\AdminCoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;

/**
 * Class VariantComponentController
 *
 * @Route(
 *      path = "product/{id}/variant",
 * )
 */
class VariantComponentController
    extends
    AbstractAdminController
{
    /**
     * Component for entity list.
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param Paginator           $paginator           Paginator instance
     * @param PaginatorAttributes $paginatorAttributes Paginator attributes
     * @param integer             $id                  Product id
     * @param integer             $page                Page
     * @param integer             $limit               Limit of items per page
     * @param string              $orderByField        Field to order by
     * @param string              $orderByDirection    Direction to order by
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/list/component/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_variant_list_component",
     *      requirements = {
     *          "page"  = "\d*",
     *          "limit" = "\d*",
     *      },
     *      defaults = {
     *          "page" = "1",
     *          "limit" = "50",
     *          "orderByField" = "id",
     *          "orderByDirection" = "DESC",
     *      },
     * )
     * @Template("AdminProductBundle:Variant:Component/listComponent.html.twig")
     * @Method({"GET"})
     *
     * @PaginatorAnnotation(
     *      attributes = "paginatorAttributes",
     *      class = "elcodi.core.product.entity.product_variant.class",
     *      innerJoins = {
     *          {"x", "product", "p", false}
     *      },
     *      wheres = {
     *          {"p", "id", "=", "~id~"}
     *      }
     * )
     */
    public function listComponentAction(
        Paginator $paginator,
        PaginatorAttributes $paginatorAttributes,
        $id,
        $page,
        $limit,
        $orderByField,
        $orderByDirection
    )
    {
        return [
            'paginator'        => $paginator,
            'page'             => $page,
            'limit'            => $limit,
            'orderByField'     => $orderByField,
            'orderByDirection' => $orderByDirection,
            'totalPages'       => $paginatorAttributes->getTotalPages(),
            'totalElements'    => $paginatorAttributes->getTotalElements(),
            'productId'        => $id
        ];
    }

    /**
     * Component for entity view
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param VariantInterface $entity Entity to view
     *
     * @return array Result
     *
     * @Route(
     *      path = "/component/{variantId}",
     *      name = "admin_variant_view_component",
     *      requirements = {
     *          "variantId" = "\d*",
     *      }
     * )
     * @Template("AdminProductBundle:Variant:Component/viewComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.product.entity.product_variant.class",
     *      mapping = {
     *          "id" = "~variantId~"
     *      }
     * )
     */
    public function viewComponentAction(VariantInterface $entity)
    {
        return [
            'entity' => $entity,
        ];
    }

    /**
     * New element action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param ProductInterface $product  Product
     * @param FormView         $formView Form view
     *
     * @return array Result
     *
     * @Route(
     *      path = "/new/component",
     *      name = "admin_variant_new_component"
     * )
     * @Template("AdminProductBundle:Variant:Component/newComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.product.entity.product.class",
     *      name = "product",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.product.factory.product_variant"
     *      },
     *      name = "entity",
     *      setters = {
     *          "setProduct": "product"
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_product_form_type_product_variant",
     *      name  = "formView",
     *      entity = "entity"
     * )
     */
    public function newComponentAction(
        ProductInterface $product,
        FormView $formView
    )
    {
        return [
            'product' => $product,
            'form'    => $formView,
        ];
    }

    /**
     * Edit element component action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param VariantInterface $entity   Entity
     * @param FormView         $formView Form view
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{variantId}/edit/component",
     *      name = "admin_variant_edit_component"
     * )
     * @Template("AdminProductBundle:Variant:Component/editComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.product.entity.product_variant.class",
     *      mapping = {
     *          "id": "~variantId~",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_product_form_type_product_variant",
     *      name  = "formView",
     *      entity = "entity"
     * )
     */
    public function editComponentAction(
        VariantInterface $entity,
        FormView $formView
    )
    {
        return [
            'entity' => $entity,
            'form'   => $formView,
        ];
    }
}
