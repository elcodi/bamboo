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

namespace Elcodi\AdminCurrencyBundle\Controller;

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
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;

/**
 * Class Controller for Currency
 */
class CurrencyController
    extends
    AbstractAdminController
    implements
    EnableableControllerInterface
{
    /**
     * Nav for currency group
     *
     * @return array Result
     *
     * @Route(
     *      path = "/currency/nav",
     *      name = "admin_currency_nav"
     * )
     * @Method({"GET"})
     * @Template
     */
    public function navAction()
    {
        return [];
    }

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
     *      path = "/currencies/list/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_currency_list",
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
     *      path = "/currency/{id}",
     *      name = "admin_currency_view",
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
     *      path = "/currency/new",
     *      name = "admin_currency_new"
     * )
     * @Template
     * @Method({"GET"})
     */
    public function newAction()
    {
        return [];
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
     *      path = "/currency/{id}/edit",
     *      name = "admin_currency_edit"
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
     * Save new element action
     *
     * Should be POST
     *
     * @param Request           $request Request
     * @param CurrencyInterface $entity  Entity to save
     * @param FormInterface     $form    Form view
     * @param boolean           $isValid Request handle is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/currency/save",
     *      name = "admin_currency_save"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.currency.factory.currency",
     *      },
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_currency_form_type_currency",
     *      name  = "form",
     *      entity = "entity",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function saveAction(
        CurrencyInterface $entity,
        FormInterface $form,
        $isValid
    )
    {
        if ($isValid) {
            $this
                ->get('elcodi.object_manager.currency')
                ->flush($entity);
        }

        return $this->redirectRoute("admin_currency_view", [
            'id' => $entity->getId(),
        ]);
    }

    /**
     * Updated edited element action
     *
     * Should be POST
     *
     * @param CurrencyInterface $entity  Entity to update
     * @param FormInterface     $form    Form view
     * @param boolean           $isValid Request handle is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/currency/{id}/update",
     *      name = "admin_currency_update"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.currency.entity.currency.class",
     *      mapping = {
     *          "id": "~id~",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_currency_form_type_currency",
     *      name  = "form",
     *      entity = "entity",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function updateAction(
        CurrencyInterface $entity,
        FormInterface $form,
        $isValid
    )
    {
        if ($isValid) {
            $this
                ->get('elcodi.object_manager.currency')
                ->flush($entity);
        }

        return $this->redirectRoute("admin_currency_view", [
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
     *      path = "/currency/{id}/enable",
     *      name = "admin_currency_enable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.currency.entity.currency.class",
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
     *      path = "/currency/{id}/disable",
     *      name = "admin_currency_disable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.currency.entity.currency.class",
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
}
