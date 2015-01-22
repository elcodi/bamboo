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

namespace Elcodi\Admin\CartBundle\Controller\Component;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Paginator as PaginatorAnnotation;
use Mmoreram\ControllerExtraBundle\ValueObject\PaginatorAttributes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormView;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;

/**
 * Class CartComponentController
 *
 * @Route(
 *      path = "cart",
 * )
 */
class CartComponentController extends AbstractAdminController
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
     *      name = "admin_cart_list_component",
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
     * @Template("AdminCartBundle:Cart:Component/listComponent.html.twig")
     * @Method({"GET"})
     *
     * @PaginatorAnnotation(
     *      attributes = "paginatorAttributes",
     *      class = "elcodi.core.cart.entity.cart.class",
     *      page = "~page~",
     *      limit = "~limit~",
     *      orderBy = {
     *          {"x", "~orderByField~", "~orderByDirection~"}
     *      },
     *      leftJoins = {
     *          {"x", "cartLines", "cl", true},
     *          {"x", "customer", "cu", true},
     *          {"x", "order", "o", true},
     *          {"cl", "product", "p", true},
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
        /**
         * @var CartInterface $cart
         */
        foreach ($paginator as $cart) {

            $this
                ->get('elcodi.cart_event_dispatcher')
                ->dispatchCartOnLoadEvent($cart);
        }

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
     * @param CartInterface $entity Entity to view
     *
     * @return array Result
     *
     * @Route(
     *      path = "/component/{id}",
     *      name = "admin_cart_view_component",
     *      requirements = {
     *          "id" = "\d*",
     *      }
     * )
     * @Template("AdminCartBundle:Cart:Component/viewComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.cart.factory.cart",
     *      },
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function viewComponentAction(CartInterface $entity)
    {
        $this
            ->get('elcodi.cart_event_dispatcher')
            ->dispatchCartOnLoadEvent($entity);

        $coupons = $this
            ->get('elcodi.cart_coupon_manager')
            ->getCoupons($entity);

        return [
            'entity'  => $entity,
            'coupons' => $coupons,
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
     *      name = "admin_cart_new_component"
     * )
     * @Template("AdminCartBundle:Cart:Component/newComponent.html.twig")
     * @Method({"GET"})
     *
     * @FormAnnotation(
     *      class = "elcodi_admin_cart_form_type_cart",
     *      name  = "formView"
     * )
     */
    public function newComponentAction(FormView $formView)
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
     * @param CartInterface $entity   Entity
     * @param FormView      $formView Form view
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/edit/component",
     *      name = "admin_cart_edit_component"
     * )
     * @Template("AdminCartBundle:Cart:Component/editComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.cart.entity.cart.class",
     *      mapping = {
     *          "id": "~id~",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_cart_form_type_cart",
     *      name  = "formView",
     *      entity = "entity"
     * )
     */
    public function editComponentAction(
        CartInterface $entity,
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
     * @param mixed $entity Entity
     *
     * @return array result
     *
     * @Route(
     *      path = "/{id}/gallery/component",
     *      name = "admin_cart_gallery_component"
     * )
     * @Template("AdminMediaBundle:Gallery:Component/view.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.cart.entity.cart.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function galleryComponentAction($entity)
    {
        $images = new ArrayCollection();

        /**
         * @var CartInterface     $entity
         * @var CartLineInterface $cartLine
         */
        foreach ($entity->getCartLines() as $cartLine) {

            $images = new ArrayCollection(array_merge(
                $images->toArray(),
                $cartLine->getProduct()->getImages()->toArray()
            ));
        }

        return [
            'entity' => $entity,
            'images' => $images,
        ];
    }
}
