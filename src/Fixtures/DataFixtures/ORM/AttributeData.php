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

namespace Elcodi\Fixtures\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Attribute\Entity\Attribute;

class AttributeData extends AbstractFixture
{
    /**
     * Loads sample fixtures for Attribute and Value entities
     *
     * @param ObjectManager $objectManager
     */
    public function load(ObjectManager $objectManager)
    {
        /**
         * @var Attribute $sizeAttribute
         * @var Attribute $colorAttribute
         */
        $sizeAttribute = $this
            ->container
            ->get('elcodi.factory.attribute')->create();

        $sizeAttribute
            ->setName('Size')
            ->setDisplayName('Size')
            ->setEnabled(true);

        $objectManager->persist($sizeAttribute);
        $this->addReference('attribute-size', $sizeAttribute);

        $colorAttribute = $this
            ->container
            ->get('elcodi.factory.attribute')
            ->create();

        $colorAttribute
            ->setName('Color')
            ->setDisplayName('Color')
            ->setEnabled(true);

        $objectManager->persist($colorAttribute);
        $this->addReference('attribute-color', $colorAttribute);

        /**
         * Values
         */

        /**
         * Colors
         */

        /**
         * Black
         */
        $blackValue = $this
            ->container
            ->get('elcodi.factory.attribute_value')
            ->create();

        $blackValue
            ->setName('Black')
            ->setDisplayName('Black')
            ->setAttribute($colorAttribute)
            ->setEnabled(true);

        $objectManager->persist($blackValue);
        $this->addReference('value-color-black', $blackValue);

        /**
         * White
         */
        $whiteValue = $this
            ->container
            ->get('elcodi.factory.attribute_value')
            ->create();

        $whiteValue
            ->setName('White')
            ->setDisplayName('White')
            ->setAttribute($colorAttribute)
            ->setEnabled(true);

        $objectManager->persist($whiteValue);
        $this->addReference('value-color-white', $whiteValue);

        /**
         * Gray
         */
        $grayValue = $this
            ->container
            ->get('elcodi.factory.attribute_value')
            ->create();

        $grayValue
            ->setName('Gray')
            ->setDisplayName('Gray')
            ->setAttribute($colorAttribute)
            ->setEnabled(true);

        $objectManager->persist($grayValue);
        $this->addReference('value-color-gray', $grayValue);

        /**
         * Sizes
         */

        /**
         * Small
         */
        $smallValue = $this
            ->container
            ->get('elcodi.factory.attribute_value')
            ->create();

        $smallValue
            ->setName('Small')
            ->setDisplayName('Small')
            ->setAttribute($sizeAttribute)
            ->setEnabled(true);

        $objectManager->persist($smallValue);
        $this->addReference('value-size-small', $smallValue);

        /**
         * Medium
         */
        $mediumValue = $this
            ->container
            ->get('elcodi.factory.attribute_value')
            ->create();

        $mediumValue
            ->setName('Medium')
            ->setDisplayName('Medium')
            ->setAttribute($sizeAttribute)
            ->setEnabled(true);

        $objectManager->persist($mediumValue);
        $this->addReference('value-size-medium', $mediumValue);

        /**
         * Large
         */
        $largeValue = $this
            ->container
            ->get('elcodi.factory.attribute_value')
            ->create();

        $largeValue
            ->setName('Large')
            ->setDisplayName('Large')
            ->setAttribute($sizeAttribute)
            ->setEnabled(true);

        $objectManager->persist($largeValue);
        $this->addReference('value-size-large', $largeValue);

        $objectManager->flush();
    }
}
