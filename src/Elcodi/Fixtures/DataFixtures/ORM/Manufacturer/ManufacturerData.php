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

namespace Elcodi\Fixtures\DataFixtures\ORM\Category;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslatorInterface;
use Elcodi\Component\Product\Entity\Interfaces\ManufacturerInterface;
use Elcodi\Component\Product\Factory\ManufacturerFactory;

/**
 * Class ManufacturerData
 */
class ManufacturerData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ManufacturerFactory       $manufacturerFactory
         * @var ObjectManager             $manufacturerObjectManager
         * @var EntityTranslatorInterface $entityTranslator
         */
        $manufacturerFactory = $this->get('elcodi.factory.manufacturer');
        $manufacturerObjectManager = $this->get('elcodi.object_manager.manufacturer');
        $entityTranslator = $this->get('elcodi.entity_translator');

        /**
         * Levis manufacturer
         *
         * @var ManufacturerInterface $levisManufacturer
         */
        $levisManufacturer = $manufacturerFactory
            ->create()
            ->setName('levis')
            ->setDescription('Levis manufacturer')
            ->setSlug('levis')
            ->setEnabled(true);

        $manufacturerObjectManager->persist($levisManufacturer);
        $this->addReference('manufacturer-levis', $levisManufacturer);
        $manufacturerObjectManager->flush($levisManufacturer);

        $entityTranslator->save($levisManufacturer, array(
            'en' => array(
                'name'            => 'Levis',
                'description'     => 'Levis',
                'slug'            => 'levis',
                'metaTitle'       => 'Levis',
                'metaDescription' => 'Levis Manufacturer',
                'metaKeywords'    => 'Levis, Manufacturer',
            ),
            'es' => array(
                'name'            => 'Levis',
                'description'     => 'Levis',
                'slug'            => 'levis',
                'metaTitle'       => 'Levis',
                'metaDescription' => 'Fabricante Levis',
                'metaKeywords'    => 'Levis, Fabricante',
            ),
            'fr' => array(
                'name'            => 'Levis',
                'description'     => 'Levis',
                'slug'            => 'levis',
                'metaTitle'       => 'Levis',
                'metaDescription' => 'Fabricant Levis',
                'metaKeywords'    => 'Levis, Fabricant',
            ),
        ));
    }
}
