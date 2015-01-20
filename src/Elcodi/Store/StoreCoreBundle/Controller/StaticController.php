<?php

/**
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

namespace Elcodi\StoreCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Elcodi\StoreCoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Class StaticController
 */
class StaticController extends Controller
{
    use TemplateRenderTrait;

    /**
     * Static content controller
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/content",
     *      name = "store_static_content"
     * )
     */
    public function contentAction()
    {
        return $this->renderTemplate('static/content.html.twig');
    }
}
