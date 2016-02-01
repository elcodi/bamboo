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

namespace Elcodi\Fixtures\DataFixtures\ORM\Customer;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\User\ElcodiUserProperties;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Class CustomerData
 */
class CustomerData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var $homeAddress AddressInterface
         */
        $homeAddress = $this->getReference('address-home');

        /**
         * @var $workAddress AddressInterface
         */
        $workAddress = $this->getReference('address-work');

        /**
         * @var CustomerInterface $customer
         */
        $customer = $this
            ->getFactory('customer')
            ->create()
            ->setPassword('1234')
            ->setEmail('customer@customer.com')
            ->setFirstName('Homer')
            ->setLastName('Simpson')
            ->setGender(ElcodiUserProperties::GENDER_MALE)
            ->addAddress($homeAddress)
            ->addAddress($workAddress)
            ->setEnabled(true);

        $manager->persist($customer);
        $this->addReference('customer', $customer);

        /**
         * @var CustomerInterface $anotherCustomer
         */
        $anotherCustomer = $this
            ->getFactory('customer')
            ->create()
            ->setPassword('1234')
            ->setEmail('another-customer@customer.com')
            ->setFirstName('Santa')
            ->setLastName('Claus')
            ->setGender(ElcodiUserProperties::GENDER_FEMALE)
            ->setEnabled(true);

        $manager->persist($anotherCustomer);
        $this->addReference('another-customer', $anotherCustomer);

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'Elcodi\Fixtures\DataFixtures\ORM\Address\AddressData',
        ];
    }
}
