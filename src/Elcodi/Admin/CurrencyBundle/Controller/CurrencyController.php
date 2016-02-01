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

namespace Elcodi\Admin\CurrencyBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Store\Entity\Interfaces\StoreInterface;

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
     * @param CurrencyInterface $currency The currency to enable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/currency/{iso}/enable",
     *      name = "admin_currency_enable"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.currency.class",
     *      name = "currency",
     *      mapping = {
     *          "iso" = "~iso~"
     *      }
     * )
     *
     * @JsonResponse()
     */
    public function enableCurrencyAction(
        CurrencyInterface $currency
    ) {
        $translator = $this->get('translator');

        $this->enableEntity($currency);

        return ['message' => $translator->trans('admin.currency.saved.enabled')];
    }

    /**
     * Disable entity
     *
     * @param CurrencyInterface $currency The currency to disable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/currency/{iso}/disable",
     *      name = "admin_currency_disable"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.currency.class",
     *      name = "currency",
     *      mapping = {
     *          "iso" = "~iso~"
     *      }
     * )
     *
     * @JsonResponse()
     */
    public function disableCurrencyAction(
        CurrencyInterface $currency
    ) {
        $translator = $this->get('translator');

        /**
         * We cannot disable the default currency
         */
        $masterCurrency = $configManager = $this
            ->get('elcodi.store')
            ->getDefaultCurrency();

        if ($currency->getIso() == $masterCurrency) {
            throw new HttpException(
                '403',
                $translator->trans('admin.currency.error.disable_master_currency')
            );
        }

        $this->disableEntity($currency);

        return ['message' => $translator->trans('admin.currency.saved.disabled')];
    }

    /**
     * Set the master currency.
     *
     * @param CurrencyInterface $currency
     *
     * @return array
     *
     * @Route(
     *      path = "/{iso}/master",
     *      name = "admin_currency_master"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.wrapper.store",
     *          "method" = "get",
     *          "static" = false
     *      },
     *      name = "store",
     *      persist = false
     * )
     * @EntityAnnotation(
     *      class = "elcodi.entity.currency.class",
     *      name = "currency",
     *      mapping = {
     *          "iso" = "~iso~"
     *      }
     * )
     *
     * @JsonResponse()
     */
    public function masterCurrencyAction(
        StoreInterface $store,
        CurrencyInterface $currency
    ) {
        $translator = $this->get('translator');
        if (!$currency->isEnabled()) {
            throw new HttpException(
                '403',
                $translator->trans('admin.currency.error.setting_disabled_master_currency')
            );
        }

        $store->setDefaultCurrency($currency);
        $this
            ->get('elcodi.object_manager.store')
            ->flush($store);

        return [
            'message' => $translator->trans('admin.currency.saved.master'),
        ];
    }
}
