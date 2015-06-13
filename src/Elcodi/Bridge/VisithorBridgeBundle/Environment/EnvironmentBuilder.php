<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

use Symfony\Component\HttpKernel\KernelInterface;
use Visithor\Bundle\Environment\SymfonyEnvironmentBuilder;

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
            ->executeCommand('doctrine:fixtures:load', [
                '--no-booster' => true,
                '--fixtures'   => $kernel
                        ->getRootDir() . '/../src/Elcodi/Fixtures',
            ])
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
}
