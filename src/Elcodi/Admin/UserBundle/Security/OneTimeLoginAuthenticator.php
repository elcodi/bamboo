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

namespace Elcodi\Admin\UserBundle\Security;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use Elcodi\Component\User\Repository\AdminUserRepository;

/**
 * Class OneTimeLoginAuthenticator responsible of checking the request for a
 * login hash and login the user in this case.
 */
class OneTimeLoginAuthenticator implements SimplePreAuthenticatorInterface
{
    /**
     * The admin user manager object.
     *
     * @var ObjectManager
     */
    private $adminUserObjectManager;

    /**
     * The Admin user repository object.
     *
     * @var AdminUserRepository
     */
    private $adminUserRepository;

    /**
     * Generates a new OneTimeLoginAuthenticator injecting it's dependencies.
     *
     * @param ObjectManager       $adminUserObjectManager The admin user manager object.
     * @param AdminUserRepository $adminUserRepository    The Admin user repository object.
     */
    public function __construct(
        ObjectManager $adminUserObjectManager,
        AdminUserRepository $adminUserRepository
    ) {
        $this->adminUserObjectManager = $adminUserObjectManager;
        $this->adminUserRepository = $adminUserRepository;
    }

    /**
     * Creates a token with the login key received on the query parameter.
     *
     * @param Request $request     The current request.
     * @param string  $providerKey The security providerKey (The firewall security area)
     *
     * @return PreAuthenticatedToken A pre-authenticated token with the login key received.
     */
    public function createToken(Request $request, $providerKey)
    {
        $loginKey = $request
            ->query
            ->get('login-key');

        if (!$loginKey) {
            throw new BadCredentialsException('No login key found');
        }

        return new PreAuthenticatedToken(
            'anon.',
            $loginKey,
            $providerKey
        );
    }

    /**
     * Authenticate the received token and returns an authenticated token.
     *
     * @param TokenInterface        $token        The token generated with the login key.
     * @param UserProviderInterface $userProvider A user provider.
     * @param string                $providerKey  The security providerKey (The firewall security area)
     *
     * @return PreAuthenticatedToken A pre-authenticated token generated using the user admin entity.
     */
    public function authenticateToken(
        TokenInterface $token,
        UserProviderInterface $userProvider,
        $providerKey
    ) {
        $loginKey = $token->getCredentials();

        $user = $this
            ->adminUserRepository
            ->findOneBy([
                'oneTimeLoginHash' => $loginKey,
            ]);

        if (!$user) {
            throw new AuthenticationException(
                sprintf('Login Key "%s" does not exist.', $loginKey)
            );
        }

        $user->setOneTimeLoginHash(null);
        $this
            ->adminUserObjectManager
            ->flush();

        return new PreAuthenticatedToken(
            $user,
            $loginKey,
            $providerKey,
            $user->getRoles()
        );
    }

    /**
     * Checks if the received token is a pre authenticated token.
     *
     * @param TokenInterface $token       The token received.
     * @param string         $providerKey The security providerKey (The firewall security area)
     *
     * @return bool Returns true if the received token is of the expected type and for the provider key we are using.
     */
    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return
            ($token instanceof PreAuthenticatedToken) &&
            ($token->getProviderKey() === $providerKey);
    }
}
