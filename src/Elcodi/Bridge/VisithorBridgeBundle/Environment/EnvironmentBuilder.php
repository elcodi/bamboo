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

namespace Elcodi\Bridge\VisithorBridgeBundle\Environment;

use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\HttpKernel\KernelInterface;
use Visithor\Bundle\Environment\SymfonyEnvironmentBuilder;

use Elcodi\Component\Geo\Entity\Interfaces\LocationInterface;
use Elcodi\Component\User\Repository\AdminUserRepository;
use Elcodi\Component\User\Repository\CustomerRepository;

/**
 * Class EnvironmentBuilder
 */
class EnvironmentBuilder extends SymfonyEnvironmentBuilder
{
    /**
     * @var CustomerRepository
     *
     * Customer Repository
     */
    protected $customerRepository;

    /**
     * @var AdminUserRepository
     *
     * Admin User Repository
     */
    protected $adminUserRepository;

    /**
     * Construct
     *
     * @param CustomerRepository  $customerRepository  Customer Repository
     * @param AdminUserRepository $adminUserRepository Admin User Repository
     */
    public function __construct(
        CustomerRepository $customerRepository,
        AdminUserRepository $adminUserRepository
    ) {
        $this->customerRepository = $customerRepository;
        $this->adminUserRepository = $adminUserRepository;
    }

    /**
     * Set up environment
     *
     * @param KernelInterface $kernel Kernel
     *
     * @return $this Self object
     */
    public function setUp(KernelInterface $kernel)
    {
        parent::setUp($kernel);

        $this
            ->loadCommonFixtures($kernel)
            ->loadLocationFixtures($kernel)
            ->executeCommand('elcodi:plugins:load');
    }

    /**
     * Get authenticated user
     *
     * @param string $role Role
     *
     * @return mixed User for authentication
     */
    public function getAuthenticationUser($role)
    {
        return 'ROLE_ADMIN' === $role
            ? $this
                ->adminUserRepository
                ->findOneBy([
                    'email' => 'admin@admin.com',
                ])
            : $this
                ->customerRepository
                ->find([
                    'email' => 'customer@customer.com',
                ]);
    }

    /**
     * Load common fixtures
     *
     * @param KernelInterface $kernel Kernel
     *
     * @return $this Self object
     */
    private function loadCommonFixtures(KernelInterface $kernel)
    {
        $rootDir = $kernel->getRootDir();

        $command =
            'doctrine:fixtures:load ' .
            '--fixtures=' . $rootDir . '/../src/Elcodi/Plugin/ ' .
            '--fixtures=' . $rootDir . '/../src/Elcodi/Fixtures ' .
            '--env=test ' .
            '--no-interaction ' .
            '--quiet ';

        $input = new StringInput($command);
        $this
            ->application
            ->run($input);

        return $this;
    }

    /**
     * Load location fixtures
     *
     * @return $this Self object
     */
    private function loadLocationFixtures(KernelInterface $kernel)
    {
        $locationDirector = $kernel
            ->getContainer()
            ->get('elcodi.director.location');

        /**
         * @var LocationInterface $locationBarcelonaCity
         */
        $locationBarcelonaCity = $locationDirector
            ->create()
            ->setId('ES_CT_B_Barcelona')
            ->setName('Barcelona')
            ->setCode('Barcelona')
            ->setType('city');
        $locationDirector->save($locationBarcelonaCity);

        /**
         * @var LocationInterface $locationBarcelonaProvince
         */
        $locationBarcelonaProvince = $locationDirector
            ->create()
            ->setId('ES_CT_B')
            ->setName('Barcelona')
            ->setCode('B')
            ->setType('province')
            ->addChildren($locationBarcelonaCity);
        $locationDirector->save($locationBarcelonaProvince);

        /**
         * @var LocationInterface $locationCatalunya
         */
        $locationCatalunya = $locationDirector
            ->create()
            ->setId('ES_CT')
            ->setName('Catalunya')
            ->setCode('CT')
            ->setType('state')
            ->addChildren($locationBarcelonaProvince);
        $locationDirector->save($locationCatalunya);

        /**
         * @var LocationInterface $locationSpain
         */
        $locationSpain = $locationDirector
            ->create()
            ->setId('ES')
            ->setName('Spain')
            ->setCode('ES')
            ->setType('country')
            ->addChildren($locationCatalunya);
        $locationDirector->save($locationSpain);

        return $this;
    }
}
