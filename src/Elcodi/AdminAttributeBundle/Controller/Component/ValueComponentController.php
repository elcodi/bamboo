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

namespace Elcodi\AdminAttributeBundle\Controller\Component;

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
use Elcodi\Component\Core\Entity\Abstracts\AbstractEntity;

/**
 * Class ValueComponentController
 *
 * @Route(
 *      path = "attribute/{id}/value",
 * )
 */
class ValueComponentController
    extends
    AbstractAdminController
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
     * @param integer             $id                  Attribute id
     * @param integer             $page                Page
     * @param integer             $limit               Limit of items per page
     * @param string              $orderByField        Field to order by
     * @param string              $orderByDirection    Direction to order by
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/list/component/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_value_list_component",
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
     * @Template("AdminAttributeBundle:Value:Component/listComponent.html.twig")
     * @Method({"GET"})
     *
     * @PaginatorAnnotation(
     *      attributes = "paginatorAttributes",
     *      class = "elcodi.core.attribute.entity.value.class",
     *      innerJoins = {
     *          {"x", "attribute", "a", false}
     *      },
     *      wheres = {
     *          {"a", "id", "=", "~id~"}
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
            'attributeId'        => $id
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
     *      path = "/component/{valueId}",
     *      name = "admin_value_view_component",
     *      requirements = {
     *          "valueId" = "\d*",
     *      }
     * )
     * @Template("AdminAttributeBundle:Value:Component/viewComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.attribute.entity.value.class",
     *      mapping = {
     *          "id" = "~valueId~"
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
     * @param integer  $id       Attribute id
     * @param FormView $formView Form view
     *
     * @return array Result
     *
     * @Route(
     *      path = "/new/component",
     *      name = "admin_value_new_component"
     * )
     * @Template("AdminAttributeBundle:Value:Component/newComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.attribute.factory.value"
     *      },
     *      name = "entity"*
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_attribute_form_type_value",
     *      name  = "formView",
     *      entity = "entity"
     * )
     */
    public function newComponentAction(
        Request $request,
        $id,
        FormView $formView
    )
    {
        return [
            'id'   => $id,
            'form' => $formView,
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
     *      path = "/{valueId}/edit/component",
     *      name = "admin_value_edit_component"
     * )
     * @Template("AdminAttributeBundle:Value:Component/editComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.attribute.entity.value.class",
     *      mapping = {
     *          "id": "~valueId~",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_attribute_form_type_value",
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
}