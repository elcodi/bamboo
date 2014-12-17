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

namespace Elcodi\AdminConfigurationBundle\Controller;

use Elcodi\Component\Configuration\Entity\Interfaces\ConfigurationInterface;
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

/**
 * Class Controller for Category
 *
 * @Route(
 *      path = "/configuration",
 * )
 */
class ConfigurationController
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
     *      path = "s/list/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_configuration_list",
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
     * @param integer $id Configuration id
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}",
     *      name = "admin_configuration_view",
     *      requirements = {
     *          "id" = "\d*",
     *      }
     * )
     * @Template("@AdminConfiguration/Configuration/view.html.twig")
     * @Method({"GET"})
     */
    public function viewAction($id)
    {
        return [
            'id' => $id
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
     *      path = "/new",
     *      name = "admin_configuration_new"
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
     * @param ConfigurationInterface $entity  Entity to save
     * @param FormInterface      $form    Form view
     * @param boolean            $isValid Request handle is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/save",
     *      name = "admin_configuration_save"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.configuration.factory.configuration"
     *      },
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_configuration_form_type_configuration",
     *      name  = "form",
     *      entity = "entity",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function saveAction(
        ConfigurationInterface $entity,
        FormInterface $form,
        $isValid
    )
    {
        if ($isValid) {
            $this
                ->get('elcodi.object_manager.configuration')
                ->flush($entity);
        }

        return $this->redirectRoute("admin_configuration_view", [
            'id' => $entity->getId(),
        ]);
    }

    /**
     * Edit element action
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsibility
     *
     * @param Request $request Request
     * @param integer $id      Entity id
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/edit",
     *      name = "admin_configuration_edit"
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
     * @param Request            $request Request
     * @param ConfigurationInterface $entity  Entity to update
     * @param FormInterface      $form    Form view
     * @param boolean            $isValid Request handle is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}/update",
     *      name = "admin_configuration_update"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.configuration.entity.configuration.class",
     *      mapping = {
     *          "id": "~id~",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_configuration_form_type_configuration",
     *      name  = "form",
     *      entity = "entity",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function updateAction(
        Request $request,
        ConfigurationInterface $entity,
        FormInterface $form,
        $isValid
    )
    {
        if ($isValid) {
            $this
                ->get('elcodi.object_manager.configuration')
                ->flush($entity);
        }

        return $this->redirectRoute("admin_configuration_view", [
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
     *      path = "/{id}/enable",
     *      name = "admin_configuration_enable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.configuration.entity.configuration.class",
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
     *      path = "/{id}/disable",
     *      name = "admin_configuration_disable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.configuration.entity.configuration.class",
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
     * Delete element action
     *
     * @param Request $request     Request
     * @param mixed   $entity      Entity to delete
     * @param string  $redirectUrl Redirect url
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}/delete",
     *      name = "admin_configuration_delete"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.configuration.entity.configuration.class",
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
            'admin_configuration_list'
        );
    }
}
