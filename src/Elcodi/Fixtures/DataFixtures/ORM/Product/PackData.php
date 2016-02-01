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

namespace Elcodi\Fixtures\DataFixtures\ORM\Product;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslatorInterface;
use Elcodi\Component\Product\ElcodiProductStock;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Product\Entity\Interfaces\ManufacturerInterface;
use Elcodi\Fixtures\DataFixtures\ORM\Product\Abstracts\AbstractPurchasableData;

/**
 * Class PackData
 */
class PackData extends AbstractPurchasableData implements DependentFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * Pack.
         *
         * @var CategoryInterface     $menCategory
         * @var ManufacturerInterface $manufacturer
         * @var CurrencyInterface     $currencyEur
         * @var ObjectDirector        $packDirector
         * @var EntityTranslatorInterface $entityTranslator
         */
        $menCategory = $this->getReference('category-men');
        $manufacturer = $this->getReference('manufacturer-levis');
        $currencyEur = $this->getReference('currency-EUR');
        $packDirector = $this->getDirector('purchasable_pack');
        $entityTranslator = $this->get('elcodi.entity_translator');

        // Id assigned = 9
        $pack4flavors = $packDirector
            ->create()
            ->setName('Pack 4 flavors')
            ->setSlug('pack-4-flavors')
            ->setDescription('Pack 4 flavors')
            ->setShortDescription('Pack 4 flavors')
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setManufacturer($manufacturer)
            ->addPurchasable($this->getReference('variant-ibiza-lips-white-small'))
            ->addPurchasable($this->getReference('product-ibiza-banana'))
            ->addPurchasable($this->getReference('product-i-was-there'))
            ->addPurchasable($this->getReference('product-a-life-style'))
            ->setStockType(ElcodiProductStock::INHERIT_STOCK)
            ->setPrice(Money::create(3000, $currencyEur))
            ->setSku('pack-sku-code-1')
            ->setHeight(30)
            ->setWidth(30)
            ->setDepth(30)
            ->setWeight(200)
            ->setShowInHome(true)
            ->setEnabled(true);

        $packDirector->save($pack4flavors);
        $this->addReference('pack-4-flavors', $pack4flavors);

        $entityTranslator->save($pack4flavors, [
            'en' => [
                'name'            => 'Pack 4 flavors English',
                'slug'            => 'pack-4-flavors-en',
                'description'     => 'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.',
                'metaTitle'       => 'Pack 4 flavors English',
                'metaDescription' => 'Pack 4 flqueavors English',
                'metaKeywords'    => 'Pack 4 flavors English',
            ],
            'es' => [
                'name'            => 'Pack 4 flavors Spanish',
                'slug'            => 'pack-4-flavors-es',
                'description'     => 'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.',
                'metaTitle'       => 'Pack 4 flavors Spanish',
                'metaDescription' => 'Pack 4 flavors Spanish',
                'metaKeywords'    => 'Pack 4 flavors Spanish',
            ],
            'fr' => [
                'name'            => 'Pack 4 flavors Français',
                'slug'            => 'pack-4-flavors-fr',
                'description'     => 'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.',
                'metaTitle'       => 'Pack 4 flavors Français',
                'metaDescription' => 'Pack 4 flavors Français',
                'metaKeywords'    => 'Pack 4 flavors Français',
            ],
            'ca' => [
                'name'            => 'Pack 4 flavors Català',
                'slug'            => 'pack-4-flavors-ca',
                'description'     => 'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.',
                'metaTitle'       => 'Pack 4 flavors Català',
                'metaDescription' => 'Pack 4 flavors Català',
                'metaKeywords'    => 'Pack 4 flavors Català',
            ],
        ]);

        $this->storePurchasableImage(
            $pack4flavors,
            'pack-1.jpg'
        );
        $packDirector->save($pack4flavors);
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
            'Elcodi\Fixtures\DataFixtures\ORM\Product\ProductData',
            'Elcodi\Fixtures\DataFixtures\ORM\Currency\CurrencyData',
            'Elcodi\Fixtures\DataFixtures\ORM\Category\CategoryData',
            'Elcodi\Fixtures\DataFixtures\ORM\Manufacturer\ManufacturerData',
            'Elcodi\Fixtures\DataFixtures\ORM\Attribute\AttributeData',
            'Elcodi\Fixtures\DataFixtures\ORM\Store\StoreData',
        ];
    }
}
