<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * This distribution is just a basic e-commerce implementation based on
 * Elcodi project.
 *
 * Feel free to edit it, and make your own
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Store\StoreCoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class StaticController extends Controller
{
    /**
     * Static content controller
     *
     * @return array
     *
     * @Route(
     *      path = "/content",
     *      name = "store_static_content"
     * )
     * @Template()
     */
    public function contentAction()
    {
        return [];
    }
}
