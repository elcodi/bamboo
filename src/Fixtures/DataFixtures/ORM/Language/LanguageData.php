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

namespace Elcodi\Fixtures\DataFixtures\ORM\Language;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;

/**
 * Class LanguageData
 */
class LanguageData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $languageObjectManager = $this->get('elcodi.object_manager.language');
        $languageFactory = $this->get('elcodi.factory.language');

        /**
         * @var LanguageInterface $languageEs
         */
        $languageEs = $languageFactory
            ->create()
            ->setName('Español')
            ->setIso('es')
            ->setEnabled(true);

        $languageObjectManager->persist($languageEs);
        $this->setReference('language-es', $languageEs);

        /**
         * @var LanguageInterface $languageEn
         */
        $languageEn = $languageFactory
            ->create()
            ->setName('English')
            ->setIso('en')
            ->setEnabled(true);

        $languageObjectManager->persist($languageEn);
        $this->setReference('language-en', $languageEs);

        /**
         * @var LanguageInterface $languageFr
         */
        $languageFr = $languageFactory
            ->create()
            ->setName('Français')
            ->setIso('fr')
            ->setEnabled(true);

        $languageObjectManager->persist($languageFr);
        $this->setReference('language-fr', $languageFr);

        $manager->flush();
    }
}
