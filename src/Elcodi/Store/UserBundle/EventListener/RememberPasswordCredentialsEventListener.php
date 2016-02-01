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

namespace Elcodi\Store\UserBundle\EventListener;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Elcodi\Component\User\Event\PasswordRecoverEvent;

/**
 * Class RememberPasswordCredentialsEventListener
 */
class RememberPasswordCredentialsEventListener
{
    /**
     * @var TokenStorageInterface
     *
     * Token storage
     */
    private $tokenStorage;

    /**
     * @var string
     *
     * Provider key
     */
    private $providerKey;

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
    public function giveCredentialsWithNewPassword(PasswordRecoverEvent $event)
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
