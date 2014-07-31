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

namespace Elcodi\AdminCartBundle\Controller\Component;

use Elcodi\AdminMediaBundle\Controller\Interfaces\GalleriableComponentControllerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineInterface;
use Mmoreram\ControllerExtraBundle\ValueObject\PaginatorAttributes;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\Tools\Pagination\Paginator;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Paginator as PaginatorAnnotation;

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\AdminCoreBundle\Controller\Abstracts\AbstractAdminController;

/**
 * Class Controller for Order
 *
 * @Route(
 *      path = "/order",
 * )
 */
class OrderComponentController
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
     * @param Paginator           $paginator           Paginator instance
     * @param PaginatorAttributes $paginatorAttributes Paginator attributes
     * @param integer             $page                Page
     * @param integer             $limit               Limit of items per page
     * @param string              $orderByField        Field to order by
     * @param string              $orderByDirection    Direction to order by
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/list/component/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_order_list_component",
     *      requirements = {
     *          "page" = "\d*",
     *          "limit" = "\d*",
     *      },
     *      defaults = {
     *          "page" = "1",
     *          "limit" = "50",
     *          "orderByField" = "id",
     *          "orderByDirection" = "DESC",
     *      },
     * )
     * @Template("AdminCartBundle:Order:Component/listComponent.html.twig")
     * @Method({"GET"})
     *
     * @PaginatorAnnotation(
     *      attributes = "paginatorAttributes",
     *      class = "elcodi.core.cart.entity.order.class",
     *      page = "~page~",
     *      limit = "~limit~",
     *      orderBy = {
     *          {"x", "~orderByField~", "~orderByDirection~"}
     *      },
     *      leftJoins = {
     *          {"x", "orderLines", "ol", true},
     *          {"x", "customer", "cu", true},
     *          {"ol", "product", "p", true},
     *      }
     * )
     */
    public function listComponentAction(
        Paginator $paginator,
        PaginatorAttributes $paginatorAttributes,
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
        ];
    }

    /**
     * Component for entity view
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param AbstractEntity $entity Entity to view
     *
     * @return array Result
     *
     * @Route(
     *      path = "/component/{id}",
     *      name = "admin_order_view_component",
     *      requirements = {
     *          "id" = "\d*",
     *      }
     * )
     * @Template("AdminCartBundle:Order:Component/viewComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.cart.factory.order",
     *      },
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function viewComponentAction(
        AbstractEntity $entity
    )
    {
        $orderCoupons = $this
            ->get('elcodi.order_coupon_manager')
            ->getOrderCoupons($entity);

        return [
            'entity' => $entity,
            'coupons' => $orderCoupons,
        ];
    }

    /**
     * New element action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param FormView $formView Form view
     *
     * @return array Result
     *
     * @Route(
     *      path = "/new/component",
     *      name = "admin_order_new_component"
     * )
     * @Template("AdminCartBundle:Order:Component/newComponent.html.twig")
     * @Method({"GET"})
     *
     * @FormAnnotation(
     *      class = "elcodi_admin_cart_form_type_order",
     *      name  = "formView"
     * )
     */
    public function newComponentAction(
        FormView $formView
    )
    {
        return [
            'form' => $formView,
        ];
    }

    /**
     * New element component action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param AbstractEntity $entity   Entity
     * @param FormView       $formView Form view
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/edit/component",
     *      name = "admin_order_edit_component"
     * )
     * @Template("AdminCartBundle:Order:Component/editComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.cart.entity.order.class",
     *      mapping = {
     *          "id": "~id~",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_cart_form_type_order",
     *      name  = "formView",
     *      entity = "entity"
     * )
     */
    public function editComponentAction(
        AbstractEntity $entity,
        FormView $formView
    )
    {
        return [
            'entity' => $entity,
            'form'   => $formView,
        ];
    }

    /**
     * View gallery action
     *
     * @param Request        $request Request
     * @param AbstractEntity $entity  Entity
     *
     * @return array result
     *
     * @Route(
     *      path = "/{id}/gallery/component",
     *      name = "admin_order_gallery_component"
     * )
     * @Template("AdminMediaBundle:Gallery:Component/view.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.cart.entity.order.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function galleryComponentAction(
        Request $request,
        AbstractEntity $entity
    )
    {
        $images = new ArrayCollection();

        /**
         * @var OrderInterface     $entity
         * @var OrderLineInterface $orderLine
         */
        foreach ($entity->getOrderLines() as $orderLine) {

            $images = new ArrayCollection(array_merge(
                $images->toArray(),
                $orderLine->getProduct()->getImages()->toArray()
            ));
        }

        return [
            'entity' => $entity,
            'images' => $images,
        ];
    }
}
