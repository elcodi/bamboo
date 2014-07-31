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

namespace Elcodi\AdminMediaBundle\Controller\Component;

use Elcodi\AdminCoreBundle\Controller\Abstracts\AbstractAdminController;
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

/**
 * Class ImageComponentController
 *
 * @Route(
 *      path = "/image"
 * )
 */
class ImageComponentController extends AbstractAdminController
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
     *      name = "admin_image_list_component",
     *      requirements = {
     *          "page" = "\d*",
     *          "limit" = "\d*",
     *      },
     *      defaults = {
     *          "page" = "1",
     *          "limit" = "50",
     *          "orderByField" = "id",
     *          "orderByDirection" = "DESC",
     *      }
     * )
     * @Template("AdminMediaBundle:Image:Component/listComponent.html.twig")
     * @Method({"GET"})
     *
     * @PaginatorAnnotation(
     *      attributes = "paginatorAttributes",
     *      class = "elcodi.core.media.entity.image.class",
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
     *      name = "admin_image_view_component",
     *      requirements = {
     *          "id" = "\d*",
     *      }
     * )
     * @Template("AdminMediaBundle:Image:Component/viewComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.media.factory.image",
     *      },
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function viewComponentAction(AbstractEntity $entity)
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
     *      path = "/new/component",
     *      name = "admin_image_new_component"
     * )
     * @Template("AdminMediaBundle:Image:Component/newComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.media.factory.image",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_image_form_type_image",
     *      name  = "formView",
     *      entity = "entity"
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
     * @param AbstractEntity $entity   Entity
     * @param FormView       $formView Form view
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/edit/component",
     *      name = "admin_image_edit_component"
     * )
     * @Template("AdminMediaBundle:Image:Component/editComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.image.entity.image.class",
     *      mapping = {
     *          "id": "~id~",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_image_form_type_image",
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
     * Dropzone component
     *
     * @return array Result
     *
     * @Route(
     *      path = "/dropzone/component",
     *      name = "admin_image_dropzone_component"
     * )
     * @Template("AdminMediaBundle:Image:Component/dropzoneComponent.html.twig")
     * @Method({"GET"})
     */
    public function dropzoneComponentAction()
    {
        return [];
    }
}
