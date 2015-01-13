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

namespace Elcodi\AdminMediaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Elcodi\AdminCoreBundle\Controller\Abstracts\AbstractAdminController;

/**
 * Class GalleryController
 *
 * @Route(
 *      path = "/gallery"
 * )
 */
class GalleryController extends AbstractAdminController
{
    /**
     * Nav for entity
     *
     * @return array Result
     *
     * @Route(
     *      path = "/nav",
     *      name = "admin_gallery_nav"
     * )
     * @Method({"GET"})
     * @Template
     */
    public function navAction()
    {
        return [];
    }
}
