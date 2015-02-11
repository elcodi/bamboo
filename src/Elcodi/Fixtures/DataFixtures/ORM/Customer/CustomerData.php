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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Fixtures\DataFixtures\ORM\Customer;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\User\ElcodiUserProperties;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Class CustomerData
 */
class CustomerData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var CustomerInterface $customer
         */
        $customer = $this
            ->container
            ->get('elcodi.factory.customer')
            ->create()
            ->setUsername('customer')
            ->setPassword('1234')
            ->setEmail('customer@customer.com')
            ->setFirstName('Homer')
            ->setLastName('Simpson')
            ->setGender(ElcodiUserProperties::GENDER_MALE)
            ->setEnabled(true);

        $manager->persist($customer);
        $this->addReference('customer', $customer);

        $manager->flush();
    }
}
