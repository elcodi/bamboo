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
use Elcodi\AdminCoreBundle\Controller\Interfaces\NavegableControllerInterface;
use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\ProductBundle\Entity\Product;
use Elcodi\ProductBundle\Entity\Variant;

/**
 * Class Controller for Variant
 *
 * @Route(
 *      path = "/product/{id}/variant",
 *      requirements = {
 *          "id" = "\d*",
 *      }
 * )
 */
class VariantController
    extends
    AbstractAdminController
    implements
    NavegableControllerInterface,
    EnableableControllerInterface
{
    /**
     * Nav for product group
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/nav",
     *      name = "admin_variant_nav"
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
     *      name = "admin_variant_list",
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
     * @param integer $id        Product id
     * @param integer $variantId Variant id
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{variantId}",
     *      name = "admin_variant_view",
     *      requirements = {
     *          "variantId" = "\d*",
     *      }
     * )
     * @Template("@AdminProduct/Variant/view.html.twig")
     * @Method({"GET"})
     */
    public function viewAction(
        Request $request,
        $id,
        $variantId
    )
    {
        return [
            'id' => $id,
            'variantId' => $variantId
        ];
    }

    /**
     * New element action
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsability
     *
     * @param $id integer Product id
     * @return array Result
     *
     * @Route(
     *      path = "/new",
     *      name = "admin_variant_new"
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
     * @param Product        $product
     * @param FormInterface  $form    Form view
     * @param boolean        $isValid Request handle is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/save",
     *      name = "admin_variant_save"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *     class = "elcodi.core.product.entity.product.class",
     *     mapping = {
     *         "id": "~id~"
     *     },
     *     name = "product"
     * )
     *
     * @EntityAnnotation(
     *     class = {
     *         "factory" = "elcodi.core.product.factory.variant"
     *     },
     *     persist  = true
     * )
     *
     * @FormAnnotation(
     *      class = "elcodi_admin_product_form_type_variant",
     *      name  = "form",
     *      entity = "entity",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function saveAction(
        Request $request,
        AbstractEntity $entity,
        Product $product,
        FormInterface $form,
        $isValid
    )
    {
        /**
         * @var Variant $entity
         */
        $entity->setProduct($product);

        $this
            ->getManagerForClass($entity)
            ->flush($entity);

        return $this->redirectRoute("admin_variant_view", [
            'id' => $product->getId(),
            'variantId' => $entity->getId()
        ]);
    }

    /**
     * Edit element action
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsability
     *
     * @param  Request $request   Request
     * @param  integer $id        Product id
     * @param  integer $variantId Variant id
     * @return array   Result
     *
     * @Route(
     *      path = "/{variantId}/edit",
     *      name = "admin_variant_edit"
     * )
     * @Template
     * @Method({"GET"})
     */
    public function editAction(
        Request $request,
        $id,
        $variantId
    )
    {
        return [
            'id' => $id,
            'variantId' => $variantId,
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
     *      path = "/{variantId}/update",
     *      name = "admin_variant_update"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.product.entity.variant.class",
     *      mapping = {
     *          "id": "~variantId~",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_product_form_type_variant",
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

        return $this->redirectRoute("admin_variant_view", [
            'id'        => $entity->getProduct()->getId(),
            'variantId' => $entity->getId(),
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
     *      path = "/{variantId}/enable",
     *      name = "admin_variant_enable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.product.entity.variant.class",
     *      mapping = {
     *          "id" = "~variantId~"
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
     *      path = "/{variantId}/disable",
     *      name = "admin_variant_disable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.product.entity.variant.class",
     *      mapping = {
     *          "id" = "~variantId~"
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
     *      path = "/{variantId}/delete",
     *      name = "admin_variant_delete"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.product.entity.variant.class",
     *      mapping = {
     *          "id" = "~variantId~"
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
