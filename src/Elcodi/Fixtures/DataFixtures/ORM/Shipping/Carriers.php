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

namespace Elcodi\Fixtures\DataFixtures\ORM\Shipping;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;

/**
 * Class Carriers
 */
class Carriers extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectDirector $carrierDirector
         * @var EntityTranslatorInterface $entityTranslator
         */
        $carrierDirector = $this->getDirector('carrier');
        $entityTranslator = $this->get('elcodi.entity_translator');

        $carrier = $carrierDirector
            ->create()
            ->setName('default')
            ->setTax($this->getReference('tax-vat-21'))
            ->setDescription('Default carrier')
            ->setEnabled(true);

        $this->setReference('carrier-default', $carrier);
        $carrierDirector->save($carrier);

        $entityTranslator->save($carrier, [
            'en' => [
                'name' => 'Basic',
                'description' => 'Our basic delivery system',
            ],
            'es' => [
                'name' => 'Básico',
                'description' => 'Nuestro sistema de entrega básico',
            ],
            'fr' => [
                'name' => 'Minimale',
                'description' => 'Notre système de livraison basique',
            ],
            'ca' => [
                'name' => 'Bàsic',
                'description' => 'El nostre sistema d\'entrega bàsic',
            ],
        ]);
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
            'Elcodi\Fixtures\DataFixtures\ORM\Tax\TaxData',
        ];
    }
}
