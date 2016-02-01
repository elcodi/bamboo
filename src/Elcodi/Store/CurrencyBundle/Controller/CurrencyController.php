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

namespace Elcodi\Store\CurrencyBundle\Controller;

use LogicException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Store\CoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Class ControllerCurrency
 *
 * @Route(
 *      path = "/currency",
 * )
 */
class CurrencyController extends Controller
{
    use TemplateRenderTrait;

    /**
     * Currency navigator
     *
     * @return Response Response
     *
     * @throws LogicException No currencies available
     *
     * @Route(
     *      path = "/nav",
     *      name = "store_currency_nav",
     *      methods = {"GET"}
     * )
     */
    public function navAction()
    {
        $currencies = $this
            ->get('elcodi.repository.currency')
            ->findBy([
                'enabled' => true,
            ]);

        if (empty($currencies)) {
            throw new LogicException(
                'There are not currencies, you must configure at least one'
            );
        }

        $activeCurrency = $this
            ->get('elcodi.wrapper.currency')
            ->get();

        return $this->renderTemplate(
            'Subpages:currency-nav.html.twig',
            [
                'currencies'     => $currencies,
                'activeCurrency' => $activeCurrency,
            ]
        );
    }

    /**
     * Switch currency to new one
     *
     * @param Request $request Request
     * @param string  $iso     Currency iso
     *
     * @return RedirectResponse Last page
     *
     * @Route(
     *      path = "/switch/{iso}",
     *      name = "store_currency_switch",
     *      methods = {"GET"}
     * )
     */
    public function switchAction(Request $request, $iso)
    {
        $currency = $this
            ->get('elcodi.repository.currency')
            ->findOneBy([
                'enabled' => true,
                'iso'     => $iso,
            ]);

        if ($currency instanceof CurrencyInterface) {
            $this
                ->get('elcodi.manager.currency_session')
                ->set($currency);
        }

        $referrer = $request
            ->headers
            ->get(
                'referer',
                $this->generateUrl('store_homepage')
            );

        return $this->redirect($referrer);
    }
}
