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

namespace Elcodi\Fixtures\DataFixtures\ORM\Configuration;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Configuration\Entity\Configuration;

/**
 * Class ConfigurationData
 */
class ConfigurationData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        /**
         * @var Configuration $storeNameConfiguration
         */
        $storeNameConfiguration = $this
            ->get('elcodi.factory.configuration')
            ->create();
        $storeNameConfiguration
            ->setNamespace('')
            ->setParameter('store.name')
            ->setValue('Bamboo Store')
            ->setEnabled(true);

        $manager->persist($storeNameConfiguration);

        $manager->flush();
    }
}
