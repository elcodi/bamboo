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

namespace Elcodi\AdminMediaBundle\Controller\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;

/**
 * Interface GalleriableComponentControllerInterface
 */
interface GalleriableComponentControllerInterface
{
    /**
     * View gallery action
     *
     * @param Request        $request Request
     * @param AbstractEntity $entity  Entity
     *
     * @return array result
     */
    public function galleryComponentAction(
        Request $request,
        AbstractEntity $entity
    );
}
