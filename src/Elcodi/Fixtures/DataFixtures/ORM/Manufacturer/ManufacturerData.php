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

namespace Elcodi\Fixtures\DataFixtures\ORM\Manufacturer;

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

        $entityTranslator->save($levisManufacturer, [
            'en' => [
                'name'            => 'Levis',
                'description'     => 'Levis',
                'slug'            => 'levis',
                'metaTitle'       => 'Levis',
                'metaDescription' => 'Levis Manufacturer',
                'metaKeywords'    => 'Levis, Manufacturer',
            ],
            'es' => [
                'name'            => 'Levis',
                'description'     => 'Levis',
                'slug'            => 'levis',
                'metaTitle'       => 'Levis',
                'metaDescription' => 'Fabricante Levis',
                'metaKeywords'    => 'Levis, Fabricante',
            ],
            'fr' => [
                'name'            => 'Levis',
                'description'     => 'Levis',
                'slug'            => 'levis',
                'metaTitle'       => 'Levis',
                'metaDescription' => 'Fabricant Levis',
                'metaKeywords'    => 'Levis, Fabricant',
            ],
            'ca' => [
                'name'            => 'Levis',
                'description'     => 'Levis',
                'slug'            => 'levis',
                'metaTitle'       => 'Levis',
                'metaDescription' => 'Fabricant Levis',
                'metaKeywords'    => 'Levis, Fabricant',
            ],
        ]);
    }
}
