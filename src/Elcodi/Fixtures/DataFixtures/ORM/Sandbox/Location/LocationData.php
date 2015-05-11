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

namespace Elcodi\Fixtures\DataFixtures\ORM\Sandbox\Location;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Geo\Entity\Interfaces\LocationInterface;

/**
 * Class LocationData
 */
class LocationData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $locationObjectmanager = $this->getObjectManager('location');

        /**
         * @var LocationInterface $locationSpain
         */
        $locationSpain = $this
            ->getFactory('location')
            ->create()
            ->setId('ES')
            ->setName('Spain')
            ->setCode('ES')
            ->setType('country');

        $locationObjectmanager->persist($locationSpain);
        $this->addReference('location_spain', $locationSpain);

        /**
         * @var LocationInterface $locationCatalunya
         */
        $locationCatalunya = $this
            ->getFactory('location')
            ->create()
            ->setId('ES_CT')
            ->setName('Catalunya')
            ->setCode('CT')
            ->setType('state')
            ->addParent($locationSpain);

        $locationObjectmanager->persist($locationCatalunya);
        $this->addReference('location_catalunya', $locationCatalunya);

        /**
         * @var LocationInterface $locationBarcelonaProvince
         */
        $locationBarcelonaProvince = $this
            ->getFactory('location')
            ->create()
            ->setId('ES_CT_B')
            ->setName('Barcelona')
            ->setCode('B')
            ->setType('province')
            ->addParent($locationCatalunya);

        $locationObjectmanager->persist($locationBarcelonaProvince);
        $this->addReference(
            'location_barcelona_province',
            $locationBarcelonaProvince
        );

        /**
         * @var LocationInterface $locationBarcelonaCity
         */
        $locationBarcelonaCity = $this
            ->getFactory('location')
            ->create()
            ->setId('ES_CT_B_Barcelona')
            ->setName('Barcelona')
            ->setCode('Barcelona')
            ->setType('city')
            ->addParent($locationBarcelonaProvince);

        $locationObjectmanager->persist($locationBarcelonaCity);
        $this->addReference(
            'location_barcelona_city',
            $locationBarcelonaCity
        );

        $locationObjectmanager->flush();
    }
}
