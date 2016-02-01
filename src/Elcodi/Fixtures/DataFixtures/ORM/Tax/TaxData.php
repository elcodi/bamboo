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

namespace Elcodi\Fixtures\DataFixtures\ORM\Tax;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Tax\Factory\TaxFactory;

/**
 * Class TaxData
 */
class TaxData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectManager $taxObjectManager
         * @var TaxFactory    $taxFactory
         */
        $taxObjectManager = $this->get('elcodi.object_manager.tax');
        $taxFactory = $this->get('elcodi.factory.tax');

        $tax21 = $taxFactory->create();
        $tax21
            ->setName('VAT 21')
            ->setDescription('VAT 21 for Spain')
            ->setValue(21.0);

        $taxObjectManager->persist($tax21);
        $this->addReference('tax-vat-21', $tax21);

        $tax16 = $taxFactory->create();
        $tax16
            ->setName('VAT 16')
            ->setDescription('VAT 16 for Spain')
            ->setValue(16.0);

        $taxObjectManager->persist($tax16);
        $this->addReference('tax-vat-16', $tax16);

        $taxObjectManager->flush();
    }
}
