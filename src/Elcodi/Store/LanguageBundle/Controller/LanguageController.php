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

namespace Elcodi\Store\LanguageBundle\Controller;

use LogicException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Store\CoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Class LanguageController
 *
 * @Route(
 *      path = "/language",
 * )
 */
class LanguageController extends Controller
{
    use TemplateRenderTrait;

    /**
     * Language navigator
     *
     * @return Response Response
     *
     * @throws LogicException No languages available
     *
     * @Route(
     *      path = "/nav",
     *      name = "store_language_nav",
     *      methods = {"GET"}
     * )
     */
    public function navAction()
    {
        $languages = $this
            ->get('elcodi.repository.language')
            ->findBy([
                'enabled' => true,
            ]);

        if (empty($languages)) {
            throw new LogicException(
                'There are not languages, you must configure at least one'
            );
        }

        $masterRequest = $this
            ->get('request_stack')
            ->getMasterRequest();

        return $this->renderTemplate(
            'Subpages:language-nav.html.twig',
            [
                'request'      => $masterRequest,
                'languages'    => $languages,
                'activeLocale' => $masterRequest->getLocale(),
            ]
        );
    }
}
