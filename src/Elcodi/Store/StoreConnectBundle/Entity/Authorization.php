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

namespace Elcodi\Store\StoreConnectBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Store\StoreConnectBundle\Entity\Interfaces\AuthorizationInterface;

/**
 * Class Authorization
 *
 * Links an OAuth authorization token with a Customer
 *
 * @author Berny Cantos <be@rny.cc>
 */
class Authorization implements AuthorizationInterface
{
    use IdentifiableTrait;

    /**
     * Name of the resource owner
     *
     * @var string
     */
    protected $resourceOwnerName;

    /**
     * Username in the remote system
     *
     * @var string
     */
    protected $username;

    /**
     * Authorization token, when it suits
     *
     * @var string
     */
    protected $authorizationToken;

    /**
     * Expiration date
     *
     * @var \DateTime
     */
    protected $expirationDate;

    /**
     * User
     *
     * @var UserInterface
     */
    protected $user;

    /**
     * @return string
     */
    public function getAuthorizationToken()
    {
        return $this->authorizationToken;
    }

    /**
     * @param string $authorizationToken
     *
     * @return self
     */
    public function setAuthorizationToken($authorizationToken)
    {
        $this->authorizationToken = $authorizationToken;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param \DateTime $expirationDate
     *
     * @return self
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getResourceOwnerName()
    {
        return $this->resourceOwnerName;
    }

    /**
     * @param string $resourceOwnerName
     *
     * @return self
     */
    public function setResourceOwnerName($resourceOwnerName)
    {
        $this->resourceOwnerName = $resourceOwnerName;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param UserInterface $user
     *
     * @return self
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Returns the attribute name
     *
     * @return string
     */
    public function __toString()
    {
        $date = $this->expirationDate->format(\DateTime::ATOM);

        return "{$this->resourceOwnerName}#{$this->username}#{$date}";
    }
}
