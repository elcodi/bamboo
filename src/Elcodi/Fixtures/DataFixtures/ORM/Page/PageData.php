<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Fixtures\DataFixtures\ORM\Page;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslatorInterface;
use Elcodi\Component\Page\ElcodiPageTypes;
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
            ->setTitle('Sobre nosotros')
            ->setPath('sobre-nosotros')
            ->setContent('<li>Sobre nosotros</li>')
            ->setMetaTitle('Sobre nosotros')
            ->setMetaDescription('Sobre nosotros')
            ->setMetaKeywords('sobre,nosotros')
            ->setType(ElcodiPageTypes::TYPE_REGULAR)
            ->setEnabled(true)
            ->setPersistent(false);

        $pageObjectManager->persist($aboutUsPage);
        $this->addReference('page-about-us', $aboutUsPage);
        $pageObjectManager->flush($aboutUsPage);

        $entityTranslator->save($aboutUsPage, [
            'en' => [
                'path'            => 'about-us',
                'title'           => 'About us',
                'content'         => '<li>About us</li>',
                'metaTitle'       => 'About us',
                'metaDescription' => 'About us',
                'metaKeywords'    => 'about,us',
            ],
            'es' => [
                'path'            => 'sobre-nosotros',
                'title'           => 'Sobre nosotros',
                'content'         => '<li>Sobre nosotros</li>',
                'metaTitle'       => 'Sobre nosotros',
                'metaDescription' => 'Sobre nosotros',
                'metaKeywords'    => 'sobre,nosotros',
            ],
            'fr' => [
                'path'            => 'a-propos',
                'title'           => 'A propos',
                'content'         => '<li>A propos</li>',
                'metaTitle'       => 'A propos',
                'metaDescription' => 'A propos',
                'metaKeywords'    => 'propos',
            ],
            'ca' => [
                'path'            => 'sobre-nosaltres',
                'title'           => 'Sobre nosaltres',
                'content'         => '<li>Sobre nosaltres</li>',
                'metaTitle'       => 'Sobre nosaltres',
                'metaDescription' => 'Sobre nosaltres',
                'metaKeywords'    => 'sobre,nosaltres',
            ],
        ]);

        /**
         * Terms and conditions page
         */
        $termsConditionsPage = $pageFactory
            ->create()
            ->setTitle('Términos y condiciones')
            ->setPath('terminos-y-condiciones')
            ->setContent('<li>Términos y condiciones</li>')
            ->setMetaTitle('Términos y condiciones')
            ->setMetaDescription('Términos y condiciones')
            ->setMetaKeywords('términos,condiciones')
            ->setType(ElcodiPageTypes::TYPE_REGULAR)
            ->setEnabled(true)
            ->setPersistent(false);

        $pageObjectManager->persist($termsConditionsPage);
        $this->addReference('page-terms-and-conditions', $termsConditionsPage);
        $pageObjectManager->flush($termsConditionsPage);

        $entityTranslator->save($termsConditionsPage, [
            'en' => [
                'path'            => 'terms-and-conditions',
                'title'           => 'Terms and conditions',
                'content'         => '<li>Terms and conditions</li>',
                'metaTitle'       => 'Terms and conditions',
                'metaDescription' => 'Terms and conditions',
                'metaKeywords'    => 'terms,conditions',
            ],
            'es' => [
                'path'            => 'terminos-y-condiciones',
                'title'           => 'Términos y condiciones',
                'content'         => '<li>Términos y condiciones</li>',
                'metaTitle'       => 'Términos y condiciones',
                'metaDescription' => 'Términos y condiciones',
                'metaKeywords'    => 'términos,condiciones',
            ],
            'fr' => [
                'path'            => 'mentions-legales',
                'title'           => 'Mentions legales',
                'content'         => '<li>Mentions legales</li>',
                'metaTitle'       => 'Mentions legales',
                'metaDescription' => 'Mentions legales',
                'metaKeywords'    => 'mentions,legales',
            ],
            'ca' => [
                'path'            => 'termes-legals',
                'title'           => 'Termes legals',
                'content'         => '<li>Termes legals</li>',
                'metaTitle'       => 'Termes legals',
                'metaDescription' => 'Termes legals',
                'metaKeywords'    => 'termes,legals',
            ],
        ]);
    }
}
