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

namespace Admin\AdminUserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\UserBundle\Entity\Interfaces\AdminUserInterface;
use Elcodi\UserBundle\ElcodiUserProperties;

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
            ->setUsername('mmoreram')
            ->setPassword('1234')
            ->setEmail('yuhu@mmoreram.com')
            ->setFirstName('Marc')
            ->setLastName('Morera')
            ->setGender(ElcodiUserProperties::GENDER_MALE)
            ->setEnabled(true);

        $manager->persist($adminUser);
        $this->addReference('admin-user', $adminUser);

        $adminUser = $this
            ->container
            ->get('elcodi.factory.admin_user')
            ->create()
            ->setUsername('zim')
            ->setPassword('1234')
            ->setEmail('zimage@tiscali.it')
            ->setFirstName('Aldo')
            ->setLastName('Chiecchia')
            ->setGender(ElcodiUserProperties::GENDER_MALE)
            ->setEnabled(true);

        $manager->persist($adminUser);
        $this->addReference('admin-user-zim', $adminUser);

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
