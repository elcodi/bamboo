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
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Product\Factory\CategoryFactory;

/**
 * Class CategoryData
 */
class CategoryData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var CategoryFactory $categoryFactory
         * @var ObjectManager             $categoryObjectManager
         * @var EntityTranslatorInterface $entityTranslator
         */
        $categoryFactory = $this->get('elcodi.factory.category');
        $categoryObjectManager = $this->get('elcodi.object_manager.category');
        $entityTranslator = $this->get('elcodi.entity_translator');

        /**
         * Women's Category
         *
         * @var CategoryInterface $category
         */
        $womenCategory = $categoryFactory
            ->create()
            ->setName('Women\'s')
            ->setSlug('women-shirts')
            ->setMetaTitle('Women Shirts')
            ->setMetaDescription('Women Shirts')
            ->setMetaKeywords('Women Shirts')
            ->setEnabled(true)
            ->setRoot(true)
            ->setPosition(0);

        $categoryObjectManager->persist($womenCategory);
        $this->addReference('category-women', $womenCategory);
        $categoryObjectManager->flush($womenCategory);

        $entityTranslator->save($womenCategory, array(
            'en' => array(
                'name' => 'Women\'s',
                'slug' => 'women-shirts',
                'metaTitle' => 'Women Shirts',
                'metaDescription' => 'Women Shirts',
                'metaKeywords' => 'Women Shirts',
            ),
            'es' => array(
                'name' => 'Mujer',
                'slug' => 'camisetas-de-mujer',
                'metaTitle' => 'Camisetas de Mujer',
                'metaDescription' => 'Camisetas de Mujer',
                'metaKeywords' => 'Camisetas Mujer',
            ),
            'fr' => array(
                'name' => 'Femme',
                'slug' => 'chemises-de-femme',
                'metaTitle' => 'Chemises de femme',
                'metaDescription' => 'Chemises de femme',
                'metaKeywords' => 'Chemises de femme',
            ),
        ));

        /**
         * Men's Category
         *
         * @var CategoryInterface $menCategory
         */
        $menCategory = $categoryFactory
            ->create()
            ->setName('Men\'s')
            ->setSlug('Men-shirts')
            ->setMetaTitle('Men Shirts')
            ->setMetaDescription('Men Shirts')
            ->setMetaKeywords('Men Shirts')
            ->setEnabled(true)
            ->setRoot(true)
            ->setPosition(1);

        $categoryObjectManager->persist($menCategory);
        $this->addReference('category-men', $menCategory);
        $categoryObjectManager->flush($menCategory);

        $entityTranslator->save($menCategory, array(
            'en' => array(
                'name' => 'Men\'s',
                'slug' => 'men-shirts',
                'metaTitle' => 'Men Shirts',
                'metaDescription' => 'Men Shirts',
                'metaKeywords' => 'Men Shirts',
            ),
            'es' => array(
                'name' => 'Hombre',
                'slug' => 'camisetas-de-hombre',
                'metaTitle' => 'Camisetas de Hombre',
                'metaDescription' => 'Camisetas de Hombre',
                'metaKeywords' => 'Camisetas Hombre',
            ),
            'fr' => array(
                'name' => 'Homem',
                'slug' => 'chemises-de-homme',
                'metaTitle' => 'Chemises de homme',
                'metaDescription' => 'Chemises de homme',
                'metaKeywords' => 'Chemises de homme',
            ),
        ));
    }
}
