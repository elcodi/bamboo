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

namespace Elcodi\Fixtures\DataFixtures\ORM\Page;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslatorInterface;
use Elcodi\Component\Page\Factory\PageFactory;

/**
 * Class PageData
 */
class PageData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var PageFactory               $pageFactory
         * @var ObjectManager             $pageObjectManager
         * @var EntityTranslatorInterface $entityTranslator
         */
        $pageFactory = $this->get('elcodi.factory.page');
        $pageObjectManager = $this->get('elcodi.object_manager.page');
        $entityTranslator = $this->get('elcodi.entity_translator');

        /**
         * About-us page
         */
        $aboutUsPage = $pageFactory
            ->create()
            ->setTitle('About us')
            ->setPath('about-us')
            ->setContent('<li>About us</li>')
            ->setMetaTitle('About us')
            ->setMetaDescription('About us')
            ->setMetaKeywords('about,us')
            ->setEnabled(true)
            ->setPersistent(true);

        $pageObjectManager->persist($aboutUsPage);
        $this->addReference('page-about-us', $aboutUsPage);
        $pageObjectManager->flush($aboutUsPage);

        $entityTranslator->save($aboutUsPage, array(
            'en' => array(
                'path'            => 'about-us',
                'title'           => 'About us',
                'content'         => '<li>About us</li>',
                'metaTitle'       => 'About us',
                'metaDescription' => 'About us',
                'metaKeywords'    => 'about,us',
            ),
            'es' => array(
                'path'            => 'sobre-nosotros',
                'title'           => 'Sobre nosotros',
                'content'         => '<li>Sobre nosotros</li>',
                'metaTitle'       => 'Sobre nosotros',
                'metaDescription' => 'Sobre nosotros',
                'metaKeywords'    => 'sobre,nosotros',
            ),
            'fr' => array(
                'path'            => 'a-propos',
                'title'           => 'A propos',
                'content'         => '<li>A propos</li>',
                'metaTitle'       => 'A propos',
                'metaDescription' => 'A propos',
                'metaKeywords'    => 'propos',
            ),
        ));

        /**
         * Terms and conditions page
         */
        $termsConditionsPage = $pageFactory
            ->create()
            ->setTitle('Terms and conditions')
            ->setPath('terms-and-conditions')
            ->setContent('<li>Terms and conditions</li>')
            ->setMetaTitle('Terms and conditions')
            ->setMetaDescription('Terms and conditions')
            ->setMetaKeywords('terms, conditions')
            ->setEnabled(true)
            ->setPersistent(true);

        $pageObjectManager->persist($termsConditionsPage);
        $this->addReference('page-terms-and-conditions', $termsConditionsPage);
        $pageObjectManager->flush($termsConditionsPage);

        $entityTranslator->save($termsConditionsPage, array(
            'en' => array(
                'path'            => 'terms-and-conditions',
                'title'           => 'Terms and conditions',
                'content'         => '<li>Terms and conditions</li>',
                'metaTitle'       => 'Terms and conditions',
                'metaDescription' => 'Terms and conditions',
                'metaKeywords'    => 'terms,conditions',
            ),
            'es' => array(
                'path'            => 'terminos-y-condiciones',
                'title'           => 'Terminos y condiciones',
                'content'         => '<li>Sobre nosotros</li>',
                'metaTitle'       => 'Terminos y condiciones',
                'metaDescription' => 'Terminos y condiciones',
                'metaKeywords'    => 'terminos,condiciones',
            ),
            'fr' => array(
                'path'            => 'mentions-legales',
                'title'           => 'Mentions legales',
                'content'         => '<li>Mentions legales</li>',
                'metaTitle'       => 'Mentions legales',
                'metaDescription' => 'Mentions legales',
                'metaKeywords'    => 'mentions,legales',
            ),
        ));
    }
}
