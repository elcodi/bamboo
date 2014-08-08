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

namespace Elcodi\Fixtures\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\UserBundle\ElcodiUserProperties;
use Elcodi\UserBundle\Entity\Interfaces\AdminUserInterface;

/**
 * Class AdminUserData
 */
class AdminUserData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var AdminUserInterface $adminUser
         */
        $adminUser = $this
            ->container
            ->get('elcodi.factory.admin_user')
            ->create()
            ->setUsername('johnwayne')
            ->setPassword('1234')
            ->setEmail('admin@admin.com')
            ->setFirstName('John')
            ->setLastName('Wayne')
            ->setGender(ElcodiUserProperties::GENDER_MALE)
            ->setEnabled(true);

        $manager->persist($adminUser);
        $this->addReference('admin-user', $adminUser);

        $manager->flush();
    }

    /**
     * Order for given fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
