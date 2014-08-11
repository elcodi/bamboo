<?php

/**
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

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Gaufrette\Adapter;
use Gaufrette\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\MediaBundle\Services\ImageManager;
use Elcodi\MediaBundle\Transformer\FileIdentifierTransformer;
use Elcodi\ProductBundle\Entity\Interfaces\CategoryInterface;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;

/**
 * Class ProductData
 */
class ProductData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ImageManager      $imageManager
         * @var Adapter           $filesystemAdapter
         * @var FileIdentifierTransformer   $fileIdentifierTransformer
         * @var CategoryInterface $menCategory
         * @var CategoryInterface $wemanCategory
         * @var CurrencyInterface $currency
         */
        $imageManager = $this->container->get('elcodi.image_manager');
        $productFactory = $this->container->get('elcodi.factory.product');
        $variantFactory = $this->container->get('elcodi.factory.product_variant');
        $filesystem = $this->container->get('elcodi.core.media.filesystem.default');
        $fileIdentifierTransformer = $this->container->get('elcodi.file_identifier_transformer');
        $menCategory = $this->getReference('category-men');
        $womenCategory = $this->getReference('category-women');
        $currency = $this->getReference('currency-dollar');
        $currencyEuros = $this->getReference('currency-euro');

        /**
         * Ibiza Lips
         *
         * @var ProductInterface $product
         */
        $product = $productFactory->create();
        $product
            ->setName('Ibiza Lips')
            ->setSlug('ibiza-lips')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )

            ->addCategory($womenCategory)
            ->setPrincipalCategory($womenCategory)
            ->setShowInHome(true)
            ->setStock(10000)
            ->setPrice(Money::create(799, $currency))
            ->setEnabled(true);

        $variantWhiteSmall = $variantFactory->create();
        $variantWhiteSmall
            ->setProduct($product)
            ->setStock(10000)
            ->setPrice(Money::create(1099, $currency))
            ->addOption($this->getReference('value-size-small'))
            ->addOption($this->getReference('value-color-white'))
            ->setEnabled(true);

        $variantBlackSmall = $variantFactory->create();
        $variantBlackSmall
            ->setProduct($product)
            ->setStock(10000)
            ->setPrice(Money::create(1199, $currency))
            ->addOption($this->getReference('value-size-small'))
            ->addOption($this->getReference('value-color-black'))
            ->setEnabled(true);

        $variantWhiteMedium = $variantFactory->create();
        $variantWhiteMedium
            ->setProduct($product)
            ->setStock(10000)
            ->setPrice(Money::create(1299, $currency))
            ->addOption($this->getReference('value-size-medium'))
            ->addOption($this->getReference('value-color-white'))
            ->setEnabled(true);

        $variantBlackMedium = $variantFactory->create();
        $variantBlackMedium
            ->setProduct($product)
            ->setStock(10000)
            ->setPrice(Money::create(1399, $currency))
            ->addOption($this->getReference('value-size-medium'))
            ->addOption($this->getReference('value-color-black'))
            ->setEnabled(true);

        $manager->persist($product);
        $manager->persist($variantWhiteSmall);
        $manager->persist($variantWhiteMedium);
        $manager->persist($variantBlackSmall);
        $manager->persist($variantBlackMedium);

        $this->addReference('product-ibiza-lips', $product);

        $this->storeImage(
            $manager,
            $imageManager,
            $filesystem,
            $fileIdentifierTransformer,
            $product,
            'product-1.jpg'
        );

        /**
         * Ibiza Banana
         *
         * @var ProductInterface $product
         */
        $product = $productFactory->create();
        $product
            ->setName('Ibiza Banana')
            ->setSlug('ibiza-banana')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->setShowInHome(true)
            ->addCategory($womenCategory)
            ->setPrincipalCategory($womenCategory)
            ->setStock(10000)
            ->setPrice(Money::create(399, $currencyEuros))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-ibiza-banana', $product);

        $this->storeImage(
            $manager,
            $imageManager,
            $filesystem,
            $fileIdentifierTransformer,
            $product,
            'product-2.jpg'
        );

        /**
         * I Was There
         *
         * @var ProductInterface $product
         */
        $product = $productFactory->create();
        $product
            ->setName('I Was There')
            ->setSlug('i-was-there')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->setShowInHome(true)
            ->addCategory($womenCategory)
            ->setPrincipalCategory($womenCategory)
            ->setStock(10000)
            ->setPrice(Money::create(2105, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-i-was-there', $product);

        $this->storeImage(
            $manager,
            $imageManager,
            $filesystem,
            $fileIdentifierTransformer,
            $product,
            'product-3.jpg'
        );

        /**
         * A Life Style
         *
         * @var ProductInterface $product
         */
        $product = $productFactory->create();
        $product
            ->setName('A Life Style')
            ->setSlug('a-life-style')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->setShowInHome(true)
            ->addCategory($womenCategory)
            ->setPrincipalCategory($womenCategory)
            ->setStock(10000)
            ->setPrice(Money::create(1290, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-a-life-style', $product);

        $this->storeImage(
            $manager,
            $imageManager,
            $filesystem,
            $fileIdentifierTransformer,
            $product,
            'product-4.jpg'
        );

        /**
         * A.M. Nesia Ibiza
         *
         * @var ProductInterface $product
         */
        $product = $productFactory->create();
        $product
            ->setName('A.M. Nesia Ibiza')
            ->setSlug('a-m-nesia-ibiza')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->setShowInHome(true)
            ->addCategory($womenCategory)
            ->setPrincipalCategory($womenCategory)
            ->setStock(10000)
            ->setPrice(Money::create(1190, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-a-m-nesia-ibiza', $product);

        $this->storeImage(
            $manager,
            $imageManager,
            $filesystem,
            $fileIdentifierTransformer,
            $product,
            'product-5.jpg'
        );

        /**
         * Amnesia poem
         *
         * @var ProductInterface $product
         */
        $product = $productFactory->create();
        $product
            ->setName('Amnesia Poem')
            ->setSlug('amnesia-poem')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->setShowInHome(true)
            ->addCategory($womenCategory)
            ->setPrincipalCategory($womenCategory)
            ->setStock(10000)
            ->setPrice(Money::create(1390, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-amnesia-poem', $product);

        $this->storeImage(
            $manager,
            $imageManager,
            $filesystem,
            $fileIdentifierTransformer,
            $product,
            'product-6.jpg'
        );

        /**
         * Pyramid
         *
         * @var ProductInterface $product
         */
        $product = $productFactory->create();
        $product
            ->setName('Pyramid')
            ->setSlug('Pyramid')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->setShowInHome(true)
            ->addCategory($womenCategory)
            ->setPrincipalCategory($womenCategory)
            ->setStock(10000)
            ->setPrice(Money::create(1090, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-pyramid', $product);

        $this->storeImage(
            $manager,
            $imageManager,
            $filesystem,
            $fileIdentifierTransformer,
            $product,
            'product-7.jpg'
        );

        /**
         * Amnesia pink
         *
         * @var ProductInterface $product
         */
        $product = $productFactory->create();
        $product
            ->setName('Amnesia Pink')
            ->setSlug('amnesia-pink')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->setShowInHome(true)
            ->addCategory($womenCategory)
            ->setPrincipalCategory($womenCategory)
            ->setStock(10000)
            ->setPrice(Money::create(1290, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-amnesia-pink', $product);

        $this->storeImage(
            $manager,
            $imageManager,
            $filesystem,
            $fileIdentifierTransformer,
            $product,
            'product-8.jpg'
        );

        /**
         * Pinky fragments
         *
         * @var ProductInterface $product
         */
        $product = $productFactory->create();
        $product
            ->setName('Pinky Fragments')
            ->setSlug('pinky-fragments')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->setShowInHome(true)
            ->addCategory($womenCategory)
            ->setPrincipalCategory($womenCategory)
            ->setStock(10000)
            ->setPrice(Money::create(1190, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-pinky-fragments', $product);

        $this->storeImage(
            $manager,
            $imageManager,
            $filesystem,
            $fileIdentifierTransformer,
            $product,
            'product-9.jpg'
        );

        /**
         * I Was There II
         *
         * @var ProductInterface $product
         */
        $product = $productFactory->create();
        $product
            ->setName('I Was There II')
            ->setSlug('i-was-there-ii')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->setShowInHome(true)
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setStock(10000)
            ->setPrice(Money::create(1190, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-i-was-there-ii', $product);

        $this->storeImage(
            $manager,
            $imageManager,
            $filesystem,
            $fileIdentifierTransformer,
            $product,
            'product-10.jpg'
        );

        /**
         * Amnesia
         *
         * @var ProductInterface $product
         */
        $product = $productFactory->create();
        $product
            ->setName('Amnesia')
            ->setSlug('amnesia')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->setShowInHome(true)
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setStock(10000)
            ->setPrice(Money::create(1800, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-amnesia', $product);

        $this->storeImage(
            $manager,
            $imageManager,
            $filesystem,
            $fileIdentifierTransformer,
            $product,
            'product-11.jpg'
        );

        /**
         * Amnesia 100%
         *
         * @var ProductInterface $product
         */
        $product = $productFactory->create();
        $product
            ->setName('Amnesia 100%')
            ->setSlug('amnesia-100-percent')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->setShowInHome(true)
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setStock(10000)
            ->setPrice(Money::create(1650, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-amnesia-100-percent', $product);

        $this->storeImage(
            $manager,
            $imageManager,
            $filesystem,
            $fileIdentifierTransformer,
            $product,
            'product-12.jpg'
        );

        /**
         * A life style
         *
         * @var ProductInterface $product
         */
        $product = $productFactory->create();
        $product
            ->setName('A Life Style II')
            ->setSlug('a-life-style-ii')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->setShowInHome(true)
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setStock(10000)
            ->setPrice(Money::create(1550, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-a-life-style-ii', $product);

        $this->storeImage(
            $manager,
            $imageManager,
            $filesystem,
            $fileIdentifierTransformer,
            $product,
            'product-13.jpg'
        );

        /**
         * All night long
         *
         * @var ProductInterface $product
         */
        $product = $productFactory->create();
        $product
            ->setName('All Night Long')
            ->setSlug('all-night-long')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->setShowInHome(true)
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setStock(10000)
            ->setPrice(Money::create(1710, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-all-night-long', $product);

        $this->storeImage(
            $manager,
            $imageManager,
            $filesystem,
            $fileIdentifierTransformer,
            $product,
            'product-14.jpg'
        );

        /**
         * A.M. Nesia Ibiza II
         *
         * @var ProductInterface $product
         */
        $product = $productFactory->create();
        $menCategory = $this->getReference('category-men');
        $product
            ->setName('A.M. Nesia Ibiza II')
            ->setSlug('a-m-nesia-ibiza-ii')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->setShowInHome(true)
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setStock(10000)
            ->setPrice(Money::create(18000, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-a-m-nesia-ibiza-ii', $product);

        $this->storeImage(
            $manager,
            $imageManager,
            $filesystem,
            $fileIdentifierTransformer,
            $product,
            'product-15.jpg'
        );

        /**
         * High Pyramid
         *
         * @var ProductInterface $product
         */
        $product = $productFactory->create();
        $menCategory = $this->getReference('category-men');
        $product
            ->setName('High Pyramid')
            ->setSlug('high-pyramid')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->setShowInHome(true)
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setStock(10000)
            ->setPrice(Money::create(2000, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-high-pyramid', $product);

        $this->storeImage(
            $manager,
            $imageManager,
            $filesystem,
            $fileIdentifierTransformer,
            $product,
            'product-16.jpg'
        );

        /**
         * Star Amnesia
         *
         * @var ProductInterface $product
         */
        $product = $productFactory->create();
        $menCategory = $this->getReference('category-men');
        $product
            ->setName('Star Amnesia')
            ->setSlug('star-amnesia')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->setShowInHome(true)
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setStock(10000)
            ->setPrice(Money::create(1145, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-star-amnesia', $product);

        $this->storeImage(
            $manager,
            $imageManager,
            $filesystem,
            $fileIdentifierTransformer,
            $product,
            'product-17.jpg'
        );

        /**
         * Ibiza 4 Ever
         *
         * @var ProductInterface $product
         */
        $product = $productFactory->create();
        $product
            ->setName('Ibiza 4 Ever')
            ->setSlug('ibiza-4-ever')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->setShowInHome(true)
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setStock(10000)
            ->setPrice(Money::create(1020, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-ibiza-4-ever', $product);

        $this->storeImage(
            $manager,
            $imageManager,
            $filesystem,
            $fileIdentifierTransformer,
            $product,
            'product-18.jpg'
        );

        $manager->flush();
    }

    /**
     * Steps necessary to store an image
     *
     * @param ObjectManager             $manager                   Manager
     * @param ImageManager              $imageManager              ImageManager
     * @param Filesystem                $filesystem                Filesystem
     * @param fileIdentifierTransformer $fileIdentifierTransformer fileIdentifierTransformer
     * @param ProductInterface          $product                   Product
     * @param string                    $imageName                 Image name
     *
     * @return ProductData self Object
     */
    protected function storeImage(
        ObjectManager $manager,
        ImageManager $imageManager,
        Filesystem $filesystem,
        fileIdentifierTransformer $fileIdentifierTransformer,
        ProductInterface $product,
        $imageName
    )
    {
        $imagePath = realpath(dirname(__FILE__) . '/images/' . $imageName);
        $image = $imageManager->createImage(new File($imagePath));
        $manager->persist($image);
        $manager->flush($image);

        $filesystem->write(
            $fileIdentifierTransformer->transform($image),
            file_get_contents($imagePath),
            true
        );

        $product->addImage($image);
        $product->setPrincipalImage($image);

        return $this;
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
            'Elcodi\Fixtures\DataFixtures\ORM\CurrencyData',
            'Elcodi\Fixtures\DataFixtures\ORM\CategoryData',
            'Elcodi\Fixtures\DataFixtures\ORM\AttributeData',
        ];
    }
}
