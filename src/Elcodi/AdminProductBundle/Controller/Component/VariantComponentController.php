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
use Symfony\Component\HttpFoundation\Request;

use Elcodi\AdminCoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\AdminMediaBundle\Controller\Interfaces\GalleriableComponentControllerInterface;
use Elcodi\Component\Core\Entity\Abstracts\AbstractEntity;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;

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
    implements
    GalleriableComponentControllerInterface
{
    /**
     * Component for entity list.
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param Request             $request             Request
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
     *      class = "elcodi.core.product.entity.variant.class",
     *      innerJoins = {
     *          {"x", "product", "p", false}
     *      },
     *      wheres = {
     *          {"p", "id", "=", "~id~"}
     *      }
     * )
     */
    public function listComponentAction(
        Request $request,
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
     * @param Request        $request Request
     * @param AbstractEntity $entity  Entity to view
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
     *      class = "elcodi.core.product.entity.variant.class",
     *      mapping = {
     *          "id" = "~variantId~"
     *      }
     * )
     */
    public function viewComponentAction(
        Request $request,
        AbstractEntity $entity
    )
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
     * @param Request  $request  Request
     * @param integer  $id       Product id
     * @param FormView $formView Form view
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
     *          "factory" = "elcodi.core.product.factory.variant"
     *      },
     *      name = "entity",
     *      setters = {
     *          "setProduct": "product"
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_product_form_type_variant",
     *      name  = "formView",
     *      entity = "entity"
     * )
     */
    public function newComponentAction(
        Request $request,
        $product,
        $id,
        FormView $formView
    )
    {
        return [
            'id' => $id,
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
     * @param Request        $request  Request
     * @param AbstractEntity $entity   Entity
     * @param FormView       $formView Form view
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
     *      class = "elcodi.core.product.entity.variant.class",
     *      mapping = {
     *          "id": "~variantId~",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_product_form_type_variant",
     *      name  = "formView",
     *      entity = "entity"
     * )
     */
    public function editComponentAction(
        Request $request,
        AbstractEntity $entity,
        FormView $formView
    )
    {
        return [
            'entity' => $entity,
            'form'   => $formView,
        ];
    }
//
//    /**
//     * View gallery action
//     *
//     * @param Request        $request Request
//     * @param AbstractEntity $entity  Entity
//     *
//     * @return array result
//     *
//     * @Route(
//     *      path = "/{id}/gallery/component",
//     *      name = "admin_product_gallery_component"
//     * )
//     * @Template("AdminMediaBundle:Gallery:Component/gallery.html.twig")
//     * @Method({"GET"})
//     *
//     * @EntityAnnotation(
//     *      class = "elcodi.core.product.entity.product.class",
//     *      mapping = {
//     *          "id" = "~id~"
//     *      }
//     * )
//     */
    public function galleryComponentAction(
        Request $request,
        AbstractEntity $entity
    )
    {
        /**
         * @var ProductInterface $entity
         */

        return [
            'entity' => $entity,
            'images' => $entity->getImages(),
        ];
    }
}
