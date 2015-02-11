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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Admin\CurrencyBundle\Controller\Components;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;

/**
 * Class CurrencyComponentController
 */
class CurrencyComponentController extends AbstractAdminController
{
    /**
     * Component for entity list.
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @return array Result
     *
     * @Route(
     *      path = "currencies/list/component",
     *      name = "admin_currency_list_component",
     * )
     * @Template("AdminCurrencyBundle:Currency:Component/listComponent.html.twig")
     * @Method({"GET"})
     */
    public function listComponentAction()
    {
        $currencies = $this
            ->get('elcodi.repository.currency')
            ->findAll();

        return [
            'paginator' => $currencies,
        ];
    }
}
