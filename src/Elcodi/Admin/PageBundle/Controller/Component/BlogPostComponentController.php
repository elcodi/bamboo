<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Admin\PageBundle\Controller\Component;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Paginator as PaginatorAnnotation;
use Mmoreram\ControllerExtraBundle\ValueObject\PaginatorAttributes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormView;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Page\Entity\Interfaces\PageInterface;

/**
 * Class PageComponentController
 *
 * @Route(
 *      path = "/blog/post"
 * )
 */
class BlogPostComponentController extends AbstractAdminController
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
     *      path = "s/component/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_blog_post_list_component",
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
     * @Template("AdminPageBundle:BlogPost:listComponent.html.twig")
     *
     * @PaginatorAnnotation(
     *      attributes = "paginatorAttributes",
     *      class = "elcodi.entity.page.class",
     *      page = "~page~",
     *      limit = "~limit~",
     *      wheres = {
     *          {"x", "type", "=", \Elcodi\Component\Page\ElcodiPageTypes::TYPE_BLOG_POST}
     *      },
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
    ) {
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
     * New element component action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param FormView      $formView Form view
     * @param PageInterface $blogPost Page
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/component",
     *      name = "admin_blog_post_edit_component",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/new/component",
     *      name = "admin_blog_post_new_component",
     *      methods = {"GET"}
     * )
     * @Template("AdminPageBundle:BlogPost:editComponent.html.twig")
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.page",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      name = "blogPost",
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_page_form_type_blog_post",
     *      name  = "formView",
     *      entity = "blogPost",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function editComponentAction(
        FormView $formView,
        PageInterface $blogPost
    ) {
        return [
            'blog_post' => $blogPost,
            'form'      => $formView,
        ];
    }
}
