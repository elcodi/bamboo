<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Admin\PageBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Page\Entity\Interfaces\PageInterface;

/**
 * Class Controller for Page
 *
 * @Route(
 *      path = "/page",
 * )
 */
class PageController extends AbstractAdminController
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
     *      path = "s/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_page_list",
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
     *      methods = {"GET"}
     * )
     * @Template
     */
    public function listAction(
        $page,
        $limit,
        $orderByField,
        $orderByDirection
    ) {
        return [
            'page'             => $page,
            'limit'            => $limit,
            'orderByField'     => $orderByField,
            'orderByDirection' => $orderByDirection,
        ];
    }

    /**
     * Edit and Saves page
     *
     * @param FormInterface $form    Form
     * @param PageInterface $page    Page
     * @param boolean       $isValid Is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}",
     *      name = "admin_page_edit",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/{id}/update",
     *      name = "admin_page_update",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"POST"}
     * )
     *
     * @Route(
     *      path = "/new",
     *      name = "admin_page_new",
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/save",
     *      name = "admin_page_save",
     *      methods = {"POST"}
     * )
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.page",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      name = "page",
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_page_form_type_page",
     *      name  = "form",
     *      entity = "page",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     *
     * @Template
     */
    public function editAction(
        FormInterface $form,
        PageInterface $page,
        $isValid
    ) {
        if ($isValid) {
            $this->flush($page);

            $this->addFlash(
                'success',
                $this
                    ->get('translator')
                    ->trans('admin.page.saved')
            );

            return $this->redirectToRoute('admin_page_list');
        }

        return [
            'page' => $page,
            'form' => $form->createView(),
        ];
    }

    /**
     * Enable entity
     *
     * @param Request          $request Request
     * @param EnabledInterface $page    Entity to enable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/enable",
     *      name = "admin_page_enable",
     *      methods = {"GET", "POST"},
     * )
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.page.class",
     *      name = "page",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function enableAction(
        Request $request,
        EnabledInterface $page
    ) {
        try {
            $this->canBeDeactivated($page);
        } catch (AccessDeniedException $exception) {
            return $this->getFailResponse($request, $exception);
        }

        return parent::enableAction(
            $request,
            $page
        );
    }

    /**
     * Disable entity
     *
     * @param Request          $request Request
     * @param EnabledInterface $page    Entity to disable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/disable",
     *      name = "admin_page_disable",
     *      methods = {"GET", "POST"},
     * )
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.page.class",
     *      name = "page",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function disableAction(
        Request $request,
        EnabledInterface $page
    ) {
        try {
            $this->canBeDeactivated($page);
        } catch (AccessDeniedException $exception) {
            return $this->getFailResponse($request, $exception);
        }

        return parent::disableAction(
            $request,
            $page
        );
    }

    /**
     * Delete entity
     *
     * @param Request $request      Request
     * @param mixed   $entity       Entity to delete
     * @param string  $redirectPath Redirect path
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}/delete",
     *      name = "admin_page_delete",
     *      methods = {"GET", "POST"},
     * )
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.page.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function deleteAction(
        Request $request,
        $entity,
        $redirectPath = null
    ) {
        try {
            $this->canBeDeactivated($entity);
        } catch (AccessDeniedException $exception) {
            return $this->getFailResponse($request, $exception);
        }

        return parent::deleteAction(
            $request,
            $entity,
            $this->generateUrl('admin_page_list')
        );
    }

    /**
     * Check the entity for activation capabilities
     *
     * @param PageInterface $page Page
     *
     * @throws AccessDeniedException
     */
    private function canBeDeactivated(PageInterface $page)
    {
        if ($page->isPersistent()) {
            throw new AccessDeniedException(
                $this
                    ->get('translator')
                    ->trans('admin.page.error.cant_modify_permanent')
            );
        }
    }
}
