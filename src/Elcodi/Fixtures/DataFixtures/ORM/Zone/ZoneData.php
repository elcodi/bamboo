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

namespace Elcodi\Fixtures\DataFixtures\ORM\Zone;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;

/**
 * Class ZoneData
 */
class ZoneData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectDirector $zoneDirector
         */
        $zones = $this->parseYaml(dirname(__FILE__) . '/zones.yml');
        $zoneDirector = $this->getDirector('zone');
        $zoneCollection = new ArrayCollection();

        foreach ($zones as $zoneName => $locations) {
            $zoneCode = strtolower(trim(preg_replace('~[^a-zA-Z\d]{1}~', '', $zoneName)));
            $zone = $zoneDirector
                ->create()
                ->setName($zoneName)
                ->setCode($zoneCode)
                ->setLocations($locations);

            $zoneCollection->add($zone);
            $this->setReference('zone-' . $zoneCode, $zone);
            $zoneDirector->save($zone);
        }

        $this->setReference('zone-collection', $zoneCollection);
    }
}
