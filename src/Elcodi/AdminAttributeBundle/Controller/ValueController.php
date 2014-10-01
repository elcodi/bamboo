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

namespace Elcodi\AdminAttributeBundle\Controller;

use Elcodi\Component\Attribute\Entity\Attribute;
use Elcodi\Component\Attribute\Entity\Value;
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
use Elcodi\Component\Core\Entity\Abstracts\AbstractEntity;

/**
 * Class Controller for Value
 *
 * @Route(
 *      path = "/attribute/{id}/value",
 *      requirements = {
 *          "id" = "\d*",
 *      }
 * )
 */
class ValueController extends
    AbstractAdminController
    implements
    EnableableControllerInterface
{
    /**
     * List elements of certain entity type.
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsability
     *
     * @param Request $request          Request
     * @param integer $page             Page
     * @param integer $limit            Limit of items per page
     * @param string  $orderByField     Field to order by
     * @param string  $orderByDirection Direction to order by
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/list/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_valuet_list",
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
        Request $request,
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
     * as this is component responsability
     *
     * @param Request $request   Request
     * @param integer $id        Attribute id
     * @param integer $valueId   Value id
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{valueId}",
     *      name = "admin_value_view",
     *      requirements = {
     *          "valueId" = "\d*",
     *      }
     * )
     * @Template("@AdminAttribute/Value/view.html.twig")
     * @Method({"GET"})
     */
    public function viewAction(
        Request $request,
        $id,
        $valueId
    )
    {
        return [
            'id' => $id,
            'valueId' => $valueId
        ];
    }

    /**
     * New element action
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsability
     *
     * @param $id integer Attribute id
     * @return array Result
     *
     * @Route(
     *      path = "/new",
     *      name = "admin_value_new"
     * )
     * @Template
     * @Method({"GET"})
     */
    public function newAction($id)
    {
        return [
            'id' => $id
        ];
    }

    /**
     * Save new element action
     *
     * Should be POST
     *
     * @param Request        $request Request
     * @param AbstractEntity $entity  Entity to save
     * @param Attribute      $attribute
     * @param FormInterface  $form    Form view
     * @param boolean        $isValid Request handle is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/save",
     *      name = "admin_value_save"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *     class = "elcodi.core.attribute.entity.attribute.class",
     *     mapping = {
     *         "id": "~id~"
     *     },
     *     name = "attribute"
     * )
     *
     * @EntityAnnotation(
     *     class = {
     *         "factory" = "elcodi.core.attribute.factory.value"
     *     },
     *     persist  = true
     * )
     *
     * @FormAnnotation(
     *      class = "elcodi_admin_attribute_form_type_value",
     *      name  = "form",
     *      entity = "entity",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function saveAction(
        Request $request,
        AbstractEntity $entity,
        Attribute $attribute,
        FormInterface $form,
        $isValid
    )
    {
        /**
         * @var Value $entity
         */
        $entity->setAttribute($attribute);

        $this
            ->getManagerForClass($entity)
            ->flush($entity);

        return $this->redirectRoute("admin_value_view", [
            'id' => $attribute->getId(),
            'valueId' => $entity->getId()
        ]);
    }

    /**
     * Edit element action
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsability
     *
     * @param  Request $request   Request
     * @param  integer $id        Attribute id
     * @param  integer $valueId   Value id
     * @return array   Result
     *
     * @Route(
     *      path = "/{valueId}/edit",
     *      name = "admin_value_edit"
     * )
     * @Template
     * @Method({"GET"})
     */
    public function editAction(
        Request $request,
        $id,
        $valueId
    )
    {
        return [
            'id' => $id,
            'valueId' => $valueId,
        ];
    }

    /**
     * Updated edited element action
     *
     * Should be POST
     *
     * @param Request        $request Request
     * @param AbstractEntity $entity  Entity to update
     * @param FormInterface  $form    Form view
     * @param boolean        $isValid Request handle is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{valueId}/update",
     *      name = "admin_value_update"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.attribute.entity.value.class",
     *      mapping = {
     *          "id": "~valueId~",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_attribute_form_type_value",
     *      name  = "form",
     *      entity = "entity",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function updateAction(
        Request $request,
        AbstractEntity $entity,
        FormInterface $form,
        $isValid
    )
    {
        $this
            ->getManagerForClass($entity)
            ->flush($entity);

        return $this->redirectRoute("admin_value_view", [
            'id'        => $entity->getAttribute()->getId(),
            'valueId'   => $entity->getId(),
        ]);
    }

    /**
     * Enable entity
     *
     * @param Request        $request Request
     * @param AbstractEntity $entity  Entity to enable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{valueId}/enable",
     *      name = "admin_value_enable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.attribute.entity.value.class",
     *      mapping = {
     *          "id" = "~valueId~"
     *      }
     * )
     */
    public function enableAction(
        Request $request,
        AbstractEntity $entity
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
     * @param Request        $request Request
     * @param AbstractEntity $entity  Entity to disable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{valueId}/disable",
     *      name = "admin_value_disable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.attribute.entity.value.class",
     *      mapping = {
     *          "id" = "~valueId~"
     *      }
     * )
     */
    public function disableAction(
        Request $request,
        AbstractEntity $entity
    )
    {
        return parent::disableAction(
            $request,
            $entity
        );
    }

    /**
     * Delete element action
     *
     * @param Request        $request     Request
     * @param AbstractEntity $entity      Entity to delete
     * @param string         $redirectUrl Redirect url
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{valueId}/delete",
     *      name = "admin_value_delete"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.attribute.entity.value.class",
     *      mapping = {
     *          "id" = "~valueId~"
     *      }
     * )
     */
    public function deleteAction(
        Request $request,
        AbstractEntity $entity,
        $redirectUrl = null
    )
    {
        return parent::deleteAction(
            $request,
            $entity
        );
    }
}