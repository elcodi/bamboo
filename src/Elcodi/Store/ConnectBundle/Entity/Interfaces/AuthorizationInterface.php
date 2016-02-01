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

namespace Elcodi\Store\ConnectBundle\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * Interface AuthorizationInterface
 *
 * @author Berny Cantos <be@rny.cc>
 */
interface AuthorizationInterface extends IdentifiableInterface
{
    /**
     * Get the name of resource owner
     *
     * @return string
     */
    public function getResourceOwnerName();

    /**
     * Get the user name in the resource owner service
     *
     * @return mixed
     */
    public function getUsername();

    /**
     * Get the related user in our system
     *
     * @return \Symfony\Component\Security\Core\User\UserInterface
     */
    public function getUser();

    /**
     * Get the OAuth authorization token for this user in that resource owner
     *
     * @return string
     */
    public function getAuthorizationToken();

    /**
     * Get the token expiration date
     *
     * @return \DateTime
     */
    public function getExpirationDate();
}
