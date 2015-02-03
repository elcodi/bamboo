<?php

/*
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

namespace Elcodi\Store\UserBundle\EventListener;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Elcodi\Component\User\Event\PasswordRecoverEvent;

/**
 * Password event listener
 */
class RememberPasswordEventListener
{
    /**
     * @var TokenStorageInterface
     *
     * SecurityContext
     */
    protected $tokenStorage;

    /**
     * @var string
     *
     * Provider key
     */
    protected $providerKey;

    /**
     * Build method
     *
     * @param TokenStorageInterface $tokenStorage Token storage
     * @param string                $providerKey  Provider key
     */
    public function __construct(TokenStorageInterface $tokenStorage, $providerKey)
    {
        $this->tokenStorage = $tokenStorage;
        $this->providerKey = $providerKey;
    }

    /**
     * on Password Recover event
     *
     * When a password is recovered, we must always create new token
     * with current user. It means that recover a password always will mean
     * log in the website
     *
     * @param PasswordRecoverEvent $event Password recover event
     */
    public function onPasswordRecover(PasswordRecoverEvent $event)
    {
        $user = $event->getUser();

        $token = new UsernamePasswordToken(
            $user,
            null,
            $this->providerKey,
            $user->getRoles()
        );

        $this->tokenStorage->setToken($token);
    }
}
