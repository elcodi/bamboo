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

namespace Elcodi\Admin\ProductBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Admin\ProductBundle\ProductEvents;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;

/**
 * Class Controller for Category
 *
 * @Route(
 *      path = "",
 * )
 */
class CategoryController extends AbstractAdminController
{
    /**
     * List elements of certain entity type.
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsibility
     *
     * @return array Result
     *
     * @Route(
     *      path = "/categories",
     *      name = "admin_category_list"
     * )
     * @Template
     * @Method({"GET"})
     */
    public function listAction()
    {
        return [];
    }

    /**
     * Edit and Saves category
     *
     * @param FormInterface     $form     Form
     * @param CategoryInterface $category Category
     * @param boolean           $isValid  Is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/category/{id}",
     *      name = "admin_category_edit",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/category/{id}/update",
     *      name = "admin_category_update",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"POST"}
     * )
     *
     * @Route(
     *      path = "/category/new",
     *      name = "admin_category_new",
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/category/new/update",
     *      name = "admin_category_save",
     *      methods = {"POST"}
     * )
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.category",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      name = "category",
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_product_form_type_category",
     *      name  = "form",
     *      entity = "category",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     *
     * @Template
     */
    public function editAction(
        FormInterface $form,
        CategoryInterface $category,
        $isValid
    ) {
        if ($isValid) {
            $this->flush($category);

            $this->addFlash('success', 'Changes saved');

            $this
                ->get('event_dispatcher')
                ->dispatch(ProductEvents::CATEGORIES_ONCHANGE);

            return $this->redirectToRoute('admin_category_edit', [
                'id' => $category->getId(),
            ]);
        }

        return [
            'category' => $category,
            'form'     => $form->createView(),
        ];
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
    ) {
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
    ) {
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
    ) {
        return parent::deleteAction(
            $request,
            $entity,
            'admin_category_list'
        );
    }
}
