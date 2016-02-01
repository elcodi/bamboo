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

namespace Elcodi\Admin\LanguageBundle\Controller\Components;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;

/**
 * Class LanguageComponentController
 *
 * @Route(
 *      path = "/language",
 * )
 */
class LanguageComponentController extends AbstractAdminController
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
     *      path = "s/component",
     *      name = "admin_language_list_component",
     * )
     * @Template("AdminLanguageBundle:Language:Component/listComponent.html.twig")
     * @Method({"GET"})
     */
    public function listComponentAction()
    {
        $languages = $this
            ->get('elcodi.repository.language')
            ->findBy(
                [],
                [
                    'enabled' => 'DESC',
                    'iso' => 'ASC',
                ]
            );

        return [
            'paginator' => $languages,
        ];
    }
}
