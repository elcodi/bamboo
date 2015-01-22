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

namespace Elcodi\Admin\CurrencyBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;

/**
 * Class Controller for Currency
 */
class CurrencyController extends AbstractAdminController
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
     * @return array Result
     *
     * @Route(
     *      path = "/currencies/list",
     *      name = "admin_currency_list"
     * )
     * @Template
     * @Method({"GET"})
     */
    public function listAction()
    {
        return [];
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
     *      path = "/currency/{iso}/enable",
     *      name = "admin_currency_enable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.currency.entity.currency.class",
     *      mapping = {
     *          "iso" = "~iso~"
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
     *      path = "/currency/{iso}/disable",
     *      name = "admin_currency_disable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.currency.entity.currency.class",
     *      mapping = {
     *          "iso" = "~iso~"
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
