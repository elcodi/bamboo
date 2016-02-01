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

namespace Elcodi\Store\ConnectBundle\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Store\ConnectBundle\Entity\Interfaces\AuthorizationInterface;

/**
 * Factory for Authorization entities
 *
 * @author Berny Cantos <be@rny.cc>
 */
class AuthorizationFactory extends AbstractFactory
{
    /**
     * Creates an Authorization instance
     *
     * @return AuthorizationInterface New Authorization entity
     */
    public function create()
    {
        /**
         * @var AuthorizationInterface $authorization
         */
        $classNamespace = $this->getEntityNamespace();
        $authorization = new $classNamespace();

        return $authorization;
    }
}
