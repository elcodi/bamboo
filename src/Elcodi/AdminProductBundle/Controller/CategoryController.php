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

namespace Elcodi\AdminProductBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\AdminCoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\AdminCoreBundle\Controller\Interfaces\EnableableControllerInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;

/**
 * Class Controller for Category
 *
 * @Route(
 *      path = "",
 * )
 */
class CategoryController
    extends
    AbstractAdminController
    implements
    EnableableControllerInterface
{
    /**
     * List elements of certain entity type.
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsibility
     *
     * @param integer $page             Page
     * @param integer $limit            Limit of items per page
     * @param string  $orderByField     Field to order by
     * @param string  $orderByDirection Direction to order by
     *
     * @return array Result
     *
     * @Route(
     *      path = "/categories/list/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_category_list",
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
     * @Template
     * @Method({"GET"})
     */
    public function listAction(
        $page,
        $limit,
        $orderByField,
        $orderByDirection
    )
    {
        return [
            'page'             => $page,
            'limit'            => $limit,
            'orderByField'     => $orderByField,
            'orderByDirection' => $orderByDirection,
        ];
    }

    /**
     * View element action.
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsibility
     *
     * @param integer $id Entity id
     *
     * @return array Result
     *
     * @Route(
     *      path = "/category/{id}",
     *      name = "admin_category_view",
     *      requirements = {
     *          "id" = "\d*",
     *      }
     * )
     * @Template
     * @Method({"GET"})
     */
    public function viewAction($id)
    {
        return [
            'id' => $id,
        ];
    }

    /**
     * New element action
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsibility
     *
     * @return array Result
     *
     * @Route(
     *      path = "/category/new",
     *      name = "admin_category_new"
     * )
     * @Template
     * @Method({"GET"})
     */
    public function newAction()
    {
        return [];
    }

    /**
     * Save new element action
     *
     * Should be POST
     *
     * @param CategoryInterface $entity  Entity to save
     * @param FormInterface     $form    Form view
     * @param boolean           $isValid Request handle is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/category/save",
     *      name = "admin_category_save"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.product.factory.category",
     *      },
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_product_form_type_category",
     *      name  = "form",
     *      entity = "entity",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function saveAction(
        CategoryInterface $entity,
        FormInterface $form,
        $isValid
    )
    {
        if ($isValid) {
            $this
                ->get('elcodi.object_manager.category')
                ->flush($entity);
        }

        return $this->redirectRoute("admin_category_view", [
            'id' => $entity->getId(),
        ]);
    }

    /**
     * New element action
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsibility
     *
     * @param integer $id Entity id
     *
     * @return array Result
     *
     * @Route(
     *      path = "/category/{id}/edit",
     *      name = "admin_category_edit"
     * )
     * @Template
     * @Method({"GET"})
     */
    public function editAction($id)
    {
        return [
            'id' => $id,
        ];
    }

    /**
     * Updated edited element action
     *
     * Should be POST
     *
     * @param CategoryInterface $entity  Entity to update
     * @param FormInterface     $form    Form view
     * @param boolean           $isValid Request handle is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/category/{id}/update",
     *      name = "admin_category_update"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.product.entity.category.class",
     *      mapping = {
     *          "id": "~id~",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_product_form_type_category",
     *      name  = "form",
     *      entity = "entity",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function updateAction(
        CategoryInterface $entity,
        FormInterface $form,
        $isValid
    )
    {
        if ($isValid) {
            $this
                ->get('elcodi.object_manager.category')
                ->flush($entity);
        }

        return $this->redirectRoute("admin_category_view", [
            'id' => $entity->getId(),
        ]);
    }

    /**
     * Enable entity
     *
     * @param Request          $request Request
     * @param EnabledInterface $entity  Entity to enable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/category/{id}/enable",
     *      name = "admin_category_enable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.product.entity.category.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function enableAction(
        Request $request,
        EnabledInterface $entity
    )
    {
        return parent::enableAction(
            $request,
            $entity
        );
    }

    /**
     * Disable entity
     *
     * @param Request          $request Request
     * @param EnabledInterface $entity  Entity to disable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/category/{id}/disable",
     *      name = "admin_category_disable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.product.entity.category.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function disableAction(
        Request $request,
        EnabledInterface $entity
    )
    {
        return parent::disableAction(
            $request,
            $entity
        );
    }

    /**
     * Delete entity
     *
     * @param Request $request     Request
     * @param mixed   $entity      Entity to delete
     * @param string  $redirectUrl Redirect url
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/category/{id}/delete",
     *      name = "admin_category_delete"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.product.entity.category.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function deleteAction(
        Request $request,
        $entity,
        $redirectUrl = null
    )
    {
        return parent::deleteAction(
            $request,
            $entity,
            'admin_category_list'
        );
    }
}
