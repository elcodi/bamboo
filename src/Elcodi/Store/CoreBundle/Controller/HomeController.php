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

namespace Elcodi\Store\CoreBundle\Controller;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Mmoreram\ControllerExtraBundle\Annotation\Paginator as PaginatorAnnotation;
use Mmoreram\ControllerExtraBundle\ValueObject\PaginatorAttributes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Common\ConfigurationBundle\Annotation\Configuration as ConfigurationAnnotation;
use Elcodi\Store\CoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Home controller
 *
 * This class should only contain home actions
 */
class HomeController extends Controller
{
    use TemplateRenderTrait;

    /**
     * Home page.
     *
     * @param Paginator           $paginator
     * @param PaginatorAttributes $paginatorAttributes
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/{page}",
     *      name = "store_homepage",
     *      methods = {"GET"},
     *      requirements = {
     *          "page" = "\d+",
     *      },
     *      defaults = {
     *          "page" = "1",
     *      },
     * )
     *
     * @ConfigurationAnnotation(
     *      name = "limit",
     *      key = "store.home_products_per_page",
     *      default = 6
     * )
     *
     * @PaginatorAnnotation(
     *      attributes = "paginatorAttributes",
     *      class = "elcodi.entity.product.class",
     *      page = "~page~",
     *      limit = "~limit~",
     *      wheres = {
     *          {"x", "enabled", "=", true},
     *          {"x", "showInHome", "=", true},
     *      },
     *      orderBy = {
     *          {"x", "updatedAt", "DESC"},
     *      }
     * )
     *
     */
    public function homeAction(
        Paginator $paginator,
        PaginatorAttributes $paginatorAttributes
    ) {
        return $this->renderTemplate(
            'Pages:home-view.html.twig',
            [
                'products' => $paginator,
                'currentPage' => $paginatorAttributes->getCurrentPage(),
                'totalPages' => $paginatorAttributes->getTotalPages(),
                'limitPerPage' => $paginatorAttributes->getLimitPerPage(),
            ]
        );
    }
}
