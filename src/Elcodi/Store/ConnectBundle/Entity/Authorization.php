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

namespace Elcodi\Store\ConnectBundle\Entity;

use DateTime;
use Symfony\Component\Security\Core\User\UserInterface;

use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Store\ConnectBundle\Entity\Interfaces\AuthorizationInterface;

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
     * @var string
     *
     * Name of the resource owner
     */
    protected $resourceOwnerName;

    /**
     * @var string
     *
     * Username in the remote system
     */
    protected $username;

    /**
     * @var string
     *
     * Authorization token, when it suits
     */
    protected $authorizationToken;

    /**
     * @var DateTime
     *
     * Expiration date
     */
    protected $expirationDate;

    /**
     * @var UserInterface
     *
     * User
     */
    protected $user;

    /**
     * Get authorization token
     *
     * @return string
     */
    public function getAuthorizationToken()
    {
        return $this->authorizationToken;
    }

    /**
     * Set current authorization token
     *
     * @param string $authorizationToken New authorization token
     *
     * @return $this Self object
     */
    public function setAuthorizationToken($authorizationToken)
    {
        $this->authorizationToken = $authorizationToken;

        return $this;
    }

    /**
     * Get expiration date
     *
     * @return DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * Set expiration date
     *
     * @param DateTime $expirationDate
     *
     * @return $this Self object
     */
    public function setExpirationDate(DateTime $expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * Get resource owner name
     *
     * @return string
     */
    public function getResourceOwnerName()
    {
        return $this->resourceOwnerName;
    }

    /**
     * Set resource owner name
     *
     * @param string $resourceOwnerName Resource owner name
     *
     * @return $this Self object
     */
    public function setResourceOwnerName($resourceOwnerName)
    {
        $this->resourceOwnerName = $resourceOwnerName;

        return $this;
    }

    /**
     * Get current username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username
     *
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
     * Get user
     *
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param UserInterface $user New user
     *
     * @return $this Self object
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
        $date = $this->expirationDate->format(DateTime::ATOM);

        return "{$this->resourceOwnerName}#{$this->username}#{$date}";
    }
}
