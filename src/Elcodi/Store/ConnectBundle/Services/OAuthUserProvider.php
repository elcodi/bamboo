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

namespace Elcodi\Store\ConnectBundle\Services;

use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Elcodi\Component\User\EventDispatcher\Interfaces\UserEventDispatcherInterface;
use Elcodi\Store\ConnectBundle\Entity\Authorization;

/**
 * Class OAuthUserProvider
 *
 * @author Berny Cantos <be@rny.cc>
 */
class OAuthUserProvider implements OAuthAwareUserProviderInterface
{
    /**
     * @var UserProviderInterface
     *
     * Where to search for valid users
     */
    private $userProvider;

    /**
     * @var ObjectDirector
     *
     * Authorization Director
     */
    private $authorizationDirector;

    /**
     * @var ObjectDirector
     *
     * Customer Director
     */
    private $customerDirector;

    /**
     * @var ObjectManager
     *
     * Customer ObjectManager
     */
    private $authorizationObjectManager;

    /**
     * @var UserEventDispatcherInterface
     *
     * User event dispatcher
     */
    private $userEventDispatcher;

    /**
     * Constructor
     *
     * @param UserProviderInterface        $userProvider               Where to search for valid users
     * @param ObjectDirector               $authorizationDirector      Authorization Director
     * @param ObjectDirector               $customerDirector           Customer Director
     * @param ObjectManager                $authorizationObjectManager Customer Object Manager
     * @param UserEventDispatcherInterface $userEventDispatcher        User event dispatcher
     */
    public function __construct(
        UserProviderInterface $userProvider,
        ObjectDirector $authorizationDirector,
        ObjectDirector $customerDirector,
        ObjectManager $authorizationObjectManager,
        UserEventDispatcherInterface $userEventDispatcher
    ) {
        $this->userProvider = $userProvider;
        $this->authorizationDirector = $authorizationDirector;
        $this->customerDirector = $customerDirector;
        $this->authorizationObjectManager = $authorizationObjectManager;
        $this->userEventDispatcher = $userEventDispatcher;
    }

    /**
     * Loads the user by a given UserResponseInterface object.
     *
     * @param UserResponseInterface $response
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $authorization = $this->findAuthorization($response);
        if (null === $authorization) {
            $user = $this->findOrCreateUser($response);
            $authorization = $this->createAuthorization($response, $user);
        }

        $this->updateAuthorization($authorization, $response);
        $this->save($authorization);

        return $authorization->getUser();
    }

    /**
     * Checks if a valid authorization exists for a given user
     *
     * @param UserResponseInterface $response Response of the ResourceOwner
     *
     * @return Authorization|null
     */
    protected function findAuthorization(UserResponseInterface $response)
    {
        $resourceOwnerName = $response
            ->getResourceOwner()
            ->getName();

        $username = $response->getUsername();

        return $this
            ->authorizationDirector
            ->findOneBy([
                'resourceOwnerName' => $resourceOwnerName,
                'username'          => $username,
            ]);
    }

    /**
     * Creates an authorization for a given user
     *
     * @param UserResponseInterface $response Response of the resource owner
     * @param UserInterface         $user     User
     *
     * @return Authorization
     */
    protected function createAuthorization(UserResponseInterface $response, UserInterface $user)
    {
        $resourceOwnerName = $response
            ->getResourceOwner()
            ->getName();

        $username = $response->getUsername();

        $authorization = $this
            ->authorizationDirector
            ->create();

        $authorization
            ->setUser($user)
            ->setResourceOwnerName($resourceOwnerName)
            ->setUsername($username);

        return $authorization;
    }

    /**
     * Updates an existing authorization with data from the resource owner
     *
     * @param Authorization         $authorization Authorization
     * @param UserResponseInterface $response      Response of the resource owner
     *
     * @return Authorization
     */
    protected function updateAuthorization(Authorization $authorization, UserResponseInterface $response)
    {
        $expirationDate = $this->getExpirationDate($response->getExpiresIn());

        $authorization
            ->setAuthorizationToken($response->getAccessToken())
            ->setExpirationDate($expirationDate);

        return $authorization;
    }

    /**
     * Persist an authorization
     *
     * @param Authorization $authorization Authorization to persist
     *
     * @return $this Self object
     */
    protected function save(Authorization $authorization)
    {
        $authorization = $this
            ->authorizationObjectManager
            ->merge($authorization);

        $this
            ->authorizationDirector
            ->save($authorization);

        return $this;
    }

    /**
     * Find or creates a user related to a given response of the resource owner
     *
     * @param UserResponseInterface $response Response of the resource owner
     *
     * @return UserInterface
     */
    protected function findOrCreateUser(UserResponseInterface $response)
    {
        $user = $this->findUser($response);
        if ($user instanceof UserInterface) {
            return $user;
        }

        return $this->createUser($response);
    }

    /**
     * Find the user related to the response of the resource owner
     *
     * @param UserResponseInterface $response
     *
     * @return UserInterface|null
     */
    protected function findUser(UserResponseInterface $response)
    {
        $username = $response->getEmail();

        try {
            return $this
                ->userProvider
                ->loadUserByUsername($username);
        } catch (UsernameNotFoundException $e) {
            return null;
        }
    }

    /**
     * Create a new user from a response
     *
     * @param UserResponseInterface $response
     *
     * @return UserInterface
     */
    protected function createUser(UserResponseInterface $response)
    {
        /**
         * @var CustomerInterface $customer
         */
        $customer = $this
            ->customerDirector
            ->create();

        $customer
            ->setEmail($response->getEmail())
            ->setFirstname($response->getRealName());

        $this
            ->customerDirector
            ->save($customer);

        $this
            ->userEventDispatcher
            ->dispatchOnCustomerRegisteredEvent($customer);

        return $customer;
    }

    /**
     * Return expiration date given time to expiration
     *
     * @param integer $secondsToExpiration
     *
     * @return DateTime
     */
    protected function getExpirationDate($secondsToExpiration)
    {
        return new DateTime(sprintf('now +%d seconds', $secondsToExpiration));
    }
}
