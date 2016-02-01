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

namespace Elcodi\Fixtures\DataFixtures\ORM\Language;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Language\Factory\LanguageFactory;

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
        /**
         * @var array           $currencies
         * @var ObjectManager   $languageObjectManager
         * @var LanguageFactory $languageFactory
         */
        $currencies = $this->parseYaml(dirname(__FILE__) . '/languages.yml');
        $languageObjectManager = $this->get('elcodi.object_manager.language');
        $languageFactory = $this->get('elcodi.factory.language');
        $languageEntities = [];

        foreach ($currencies as $languageIso => $languageData) {
            $language = $languageFactory
                ->create()
                ->setIso($languageIso)
                ->setName($languageData['name'])
                ->setEnabled((boolean) $languageData['enabled']);

            $this->setReference('language-' . $languageIso, $language);
            $languageObjectManager->persist($language);
            $languageEntities[] = $language;
        }

        $languageObjectManager->flush($languageEntities);
    }
}
