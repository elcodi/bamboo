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

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;

/**
 * Class SessionCurrencyController
 *
 * @Route(
 *      path = "/currency",
 * )
 */
class SessionCurrencyController extends Controller
{
    /**
     * Switch currency to new one
     *
     * @return array Currency data
     *
     * @Route(
     *      path = "/switch/nav",
     *      name = "admin_currency_switch_nav"
     * )
     * @Template
     */
    public function navAction()
    {
        $currencies = $this
            ->get('elcodi.repository.currency')
            ->findBy([
                'enabled' => true,
            ]);

        $currentCurrency = $this
                ->get('elcodi.currency_wrapper')
                ->loadCurrency();

        return [
            'currencies' => $currencies,
            'currentCurrency' => $currentCurrency,
        ];
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
     *      name = "admin_currency_switch"
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
                ->get('elcodi.currency_session_manager')
                ->set($currency);
        }

        $referrer = $request->headers->get('referer')
            ?: $this->generateUrl('store_homepage');

        return $this->redirect($referrer);
    }
}
