<?php

/**
 * This file is part of BeEcommerce.
 *
 * @author Befactory Team
 * @since  2013
 */

namespace Elcodi\StoreProductBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\ProductBundle\Entity\Interfaces\CategoryInterface;

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
         * Women's Category
         *
         * @var CategoryInterface $category
         */
        $womenCategory = $this->container->get('elcodi.core.product.factory.category')->create();
        $womenCategory
            ->setName('Women\'s')
            ->setSlug('women-shirts')
            ->setEnabled(true)
            ->setRoot(true);

        $manager->persist($womenCategory);
        $this->addReference('category-women', $womenCategory);

        /**
         * Men's Category
         *
         * @var CategoryInterface $menCategory
         */
        $menCategory = $this->container->get('elcodi.core.product.factory.category')->create();
        $menCategory
            ->setName('Men\'s')
            ->setSlug('men-shirts')
            ->setEnabled(true)
            ->setRoot(true);

        $manager->persist($menCategory);
        $this->addReference('category-men', $menCategory);

        $manager->flush();
    }

    /**
     * Order for given fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
