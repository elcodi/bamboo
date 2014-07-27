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

namespace Admin\AdminCurrencyBundle\Controller\Components;

use Symfony\Component\Form\FormView;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Paginator as PaginatorAnnotation;
use Mmoreram\ControllerExtraBundle\ValueObject\PaginatorAttributes;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;

use Admin\AdminCoreBundle\Controller\Abstracts\AbstractAdminController;

/**
 * Class CurrencyComponentController
 */
class CurrencyComponentController extends AbstractAdminController
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
     *      path = "currencies/list/component/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_currency_list_component",
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
     * @Template("AdminCurrencyBundle:Currency:Component/listComponent.html.twig")
     * @Method({"GET"})
     *
     * @PaginatorAnnotation(
     *      attributes = "paginatorAttributes",
     *      class = "elcodi.core.currency.entity.currency.class",
     *      page = "~page~",
     *      limit = "~limit~",
     *      orderBy = {
     *          {"x", "~orderByField~", "~orderByDirection~"}
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
            'paginator'           => $paginator,
            'page'                => $page,
            'limit'               => $limit,
            'orderByField'        => $orderByField,
            'orderByDirection'    => $orderByDirection,
            'paginatorAttributes' => $paginatorAttributes,
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
     *      path = "currency/component/{id}",
     *      name = "admin_currency_view_component",
     *      requirements = {
     *          "id" = "\d*",
     *      }
     * )
     * @Template("AdminCurrencyBundle:Currency:Component/viewComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.currency.factory.currency",
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
     * @param FormView $formView Form view
     *
     * @return array Result
     *
     * @Route(
     *      path = "/currency/new/component",
     *      name = "admin_currency_new_component"
     * )
     * @Template("AdminCurrencyBundle:Currency:Component/newComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.currency.factory.currency",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_currency_form_type_currency",
     *      name  = "formView",
     *      entity = "entity"
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
     *      path = "/currency/{id}/edit/component",
     *      name = "admin_currency_edit_component"
     * )
     * @Template("AdminCurrencyBundle:Currency:Component/editComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.currency.entity.currency.class",
     *      mapping = {
     *          "id": "~id~",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_currency_form_type_currency",
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
}
