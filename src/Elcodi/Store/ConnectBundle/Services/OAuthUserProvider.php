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

namespace Elcodi\Store\ConnectBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
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
     */
    protected $userProvider;

    /**
     * @var ObjectRepository
     */
    protected $authorizationRepository;

    /**
     * @var ObjectManager
     */
    protected $authorizationManager;

    /**
     * @var AbstractFactory
     */
    private $customerFactory;

    /**
     * @var ObjectManager
     */
    private $customerObjectManager;

    /**
     * @param UserProviderInterface $provider
     * @param ObjectRepository      $authorizationRepository
     * @param ObjectManager         $authorizationManager
     * @param AbstractFactory       $customerFactory
     * @param ObjectManager         $customerObjectManager
     */
    public function __construct(
        UserProviderInterface $provider,
        ObjectRepository $authorizationRepository,
        ObjectManager $authorizationManager,
        AbstractFactory $customerFactory,
        ObjectManager $customerObjectManager
    )
    {
        $this->userProvider = $provider;
        $this->authorizationRepository = $authorizationRepository;
        $this->authorizationManager = $authorizationManager;
        $this->customerFactory = $customerFactory;
        $this->customerObjectManager = $customerObjectManager;
    }

    /**
     * @param UserResponseInterface $response
     *
     * @return UserInterface
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
     * @param UserResponseInterface $response
     *
     * @return Authorization
     */
    protected function findAuthorization(UserResponseInterface $response)
    {
        $authorization = $this->authorizationRepository->findOneBy([
            'resourceOwnerName' => $response->getResourceOwner()->getName(),
            'username' => $response->getUsername(),
        ]);

        return $authorization;
    }

    /**
     * @param UserResponseInterface $response
     * @param UserInterface         $user
     *
     * @return Authorization
     */
    protected function createAuthorization(UserResponseInterface $response, UserInterface $user)
    {
        $authorization = new Authorization();
        $authorization
            ->setUser($user)
            ->setResourceOwnerName($response->getResourceOwner()->getName())
            ->setUsername($response->getUsername())
        ;

        return $authorization;
    }

    /**
     * @param Authorization         $authorization
     * @param UserResponseInterface $response
     *
     * @return Authorization
     */
    protected function updateAuthorization(Authorization $authorization, UserResponseInterface $response)
    {
        $expirationDate = $this->getExpirationDate($response->getExpiresIn());
        $authorization
            ->setAuthorizationToken($response->getAccessToken())
            ->setExpirationDate($expirationDate)
        ;

        return $authorization;
    }

    /**
     * @param Authorization $authorization
     */
    protected function save(Authorization $authorization)
    {
        $authorization = $this->authorizationManager->merge($authorization);

        $this->authorizationManager->persist($authorization);
        $this->authorizationManager->flush($authorization);
    }

    /**
     * @param UserResponseInterface $response
     *
     * @return UserInterface
     */
    protected function findOrCreateUser(UserResponseInterface $response)
    {
        $user = $this->findUser($response);
        if (null === $user) {
            $user = $this->createUser($response);
        }

        return $user;
    }

    /**
     * @param UserResponseInterface $response
     *
     * @return UserInterface
     */
    protected function findUser(UserResponseInterface $response)
    {
        $username = $response->getEmail();

        try {
            $user = $this->userProvider->loadUserByUsername($username);
        } catch (UsernameNotFoundException $e) {
            $user = null;
        }

        return $user;
    }

    /**
     * @param UserResponseInterface $response
     *
     * @return UserInterface
     */
    protected function createUser(UserResponseInterface $response)
    {
        /**
         * @var CustomerInterface $customer
         */
        $customer = $this->customerFactory->create();
        $customer
            ->setEmail($response->getEmail())
            ->setFirstname($response->getRealName())
            ->setUsername($response->getNickname())
        ;

        $this->authorizationManager->persist($customer);
        $this->authorizationManager->flush($customer);

        return $customer;
    }

    /**
     * Return expiration date given time to expiration
     *
     * @param integer $secondsToExpiration
     *
     * @return \DateTime
     */
    protected function getExpirationDate($secondsToExpiration)
    {
        return new \DateTime(sprintf('now +%d seconds', $secondsToExpiration));
    }
}
