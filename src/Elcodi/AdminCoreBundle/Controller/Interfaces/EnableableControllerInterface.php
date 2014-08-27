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

namespace Elcodi\AdminCoreBundle\Controller\Interfaces;

use Symfony\Component\HttpFoundation\Request;

use Elcodi\Component\Core\Entity\Abstracts\AbstractEntity;

/**
 * Interface EnableableControllerInterface
 */
interface EnableableControllerInterface
{
    /**
     * Enable entity
     *
     * @param Request        $request Request
     * @param AbstractEntity $entity  Entity to enable
     *
     * @return array Result
     */
    public function enableAction(
        Request $request,
        AbstractEntity $entity
    );

    /**
     * Disable entity
     *
     * @param Request        $request Request
     * @param AbstractEntity $entity  Entity to disable
     *
     * @return array Result
     */
    public function disableAction(
        Request $request,
        AbstractEntity $entity
    );
}
