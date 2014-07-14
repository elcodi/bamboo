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

namespace Store\StoreProductBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\MediaBundle\Services\ImageManager;
use Elcodi\MediaBundle\Transformer\FileTransformer;
use Elcodi\ProductBundle\Entity\Interfaces\CategoryInterface;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Gaufrette\Adapter;
use Gaufrette\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class ProductData
 */
class ProductData extends AbstractFixture
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
         * @var FileTransformer   $fileTransformer
         * @var CategoryInterface $menCategory
         * @var CategoryInterface $wemanCategory
         * @var CurrencyInterface $currency
         */
        $imageManager = $this->container->get('elcodi.core.media.service.image_manager');
        $imageFactory = $this->container->get('elcodi.core.product.factory.product');
        $filesystem = $this->container->get('elcodi.core.media.filesystem.default');
        $fileTransformer = $this->container->get('elcodi.core.media.transformer.file');
        $menCategory = $this->getReference('category-men');
        $womenCategory = $this->getReference('category-women');
        $currency = $this->getReference('currency-dollar');
        $currencyEuros = $this->getReference('currency-euro');

        /**
         * Ibiza Lips
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
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
            ->setStock(10000)
            ->setPrice(new Money(799, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-ibiza-lips', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-1.jpg');

        /**
         * Ibiza Banana
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('Ibiza Banana')
            ->setSlug('ibiza-banana')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($womenCategory)
            ->setPrincipalCategory($womenCategory)
            ->setStock(10000)
            ->setPrice(new Money(399, $currencyEuros))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-ibiza-banana', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-2.jpg');

        /**
         * I Was There
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('I Was There')
            ->setSlug('i-was-there')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($womenCategory)
            ->setPrincipalCategory($womenCategory)
            ->setStock(10000)
            ->setPrice(new Money(2105, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-i-was-there', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-3.jpg');

        /**
         * A Life Style
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('A Life Style')
            ->setSlug('a-life-style')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($womenCategory)
            ->setPrincipalCategory($womenCategory)
            ->setStock(10000)
            ->setPrice(new Money(1290, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-a-life-style', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-4.jpg');

        /**
         * A.M. Nesia Ibiza
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('A.M. Nesia Ibiza')
            ->setSlug('a-m-nesia-ibiza')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($womenCategory)
            ->setPrincipalCategory($womenCategory)
            ->setStock(10000)
            ->setPrice(new Money(1190, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-a-m-nesia-ibiza', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-5.jpg');

        /**
         * Amnesia poem
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('Amnesia Poem')
            ->setSlug('amnesia-poem')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($womenCategory)
            ->setPrincipalCategory($womenCategory)
            ->setStock(10000)
            ->setPrice(new Money(1390, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-amnesia-poem', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-6.jpg');

        /**
         * Pyramid
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('Pyramid')
            ->setSlug('Pyramid')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($womenCategory)
            ->setPrincipalCategory($womenCategory)
            ->setStock(10000)
            ->setPrice(new Money(1090, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-pyramid', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-7.jpg');

        /**
         * Amnesia pink
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('Amnesia Pink')
            ->setSlug('amnesia-pink')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($womenCategory)
            ->setPrincipalCategory($womenCategory)
            ->setStock(10000)
            ->setPrice(new Money(1290, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-amnesia-pink', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-8.jpg');

        /**
         * Pinky fragments
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('Pinky Fragments')
            ->setSlug('pinky-fragments')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($womenCategory)
            ->setPrincipalCategory($womenCategory)
            ->setStock(10000)
            ->setPrice(new Money(1190, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-pinky-fragments', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-9.jpg');

        /**
         * I Was There II
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('I Was There II')
            ->setSlug('i-was-there-ii')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setStock(10000)
            ->setPrice(new Money(1190, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-i-was-there-ii', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-10.jpg');

        /**
         * Amnesia
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('Amnesia')
            ->setSlug('amnesia')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setStock(10000)
            ->setPrice(new Money(1800, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-amnesia', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-11.jpg');

        /**
         * Amnesia 100%
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('Amnesia 100%')
            ->setSlug('amnesia-100-percent')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setStock(10000)
            ->setPrice(new Money(1650, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-amnesia-100-percent', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-12.jpg');

        /**
         * A life style
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('A Life Style II')
            ->setSlug('a-life-style-ii')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setStock(10000)
            ->setPrice(new Money(1550, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-a-life-style-ii', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-13.jpg');

        /**
         * All night long
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('All Night Long')
            ->setSlug('all-night-long')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setStock(10000)
            ->setPrice(new Money(1710, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-all-night-long', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-14.jpg');

        /**
         * A.M. Nesia Ibiza II
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $menCategory = $this->getReference('category-men');
        $product
            ->setName('A.M. Nesia Ibiza II')
            ->setSlug('a-m-nesia-ibiza-ii')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setStock(10000)
            ->setPrice(new Money(18000, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-a-m-nesia-ibiza-ii', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-15.jpg');

        /**
         * High Pyramid
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $menCategory = $this->getReference('category-men');
        $product
            ->setName('High Pyramid')
            ->setSlug('high-pyramid')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setStock(10000)
            ->setPrice(new Money(2000, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-high-pyramid', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-16.jpg');

        /**
         * Star Amnesia
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $menCategory = $this->getReference('category-men');
        $product
            ->setName('Star Amnesia')
            ->setSlug('star-amnesia')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setStock(10000)
            ->setPrice(new Money(1145, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-star-amnesia', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-17.jpg');

        /**
         * Ibiza 4 Ever
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('Ibiza 4 Ever')
            ->setSlug('ibiza-4-ever')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setStock(10000)
            ->setPrice(new Money(1020, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-ibiza-4-ever', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-18.jpg');

        $manager->flush();
    }

    /**
     * Order for given fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 5;
    }

    /**
     * Steps necessary to store an image
     *
     * @param ObjectManager    $manager         Manager
     * @param ImageManager     $imageManager    ImageManager
     * @param Filesystem       $filesystem      Filesystem
     * @param FileTransformer  $fileTransformer FileTransformer
     * @param ProductInterface $product         Product
     * @param string           $imageName       Image name
     *
     * @return ProductData self Object
     */
    protected function storeImage(
        ObjectManager $manager,
        ImageManager $imageManager,
        Filesystem $filesystem,
        FileTransformer $fileTransformer,
        ProductInterface $product,
        $imageName
    )
    {
        $imagePath = realpath(dirname(__FILE__) . '/images/' . $imageName);
        $image = $imageManager->createImage(new File($imagePath));
        $manager->persist($image);
        $manager->flush($image);

        $filesystem->write(
            $fileTransformer->transform($image),
            file_get_contents($imagePath),
            true
        );

        $product->addImage($image);
        $product->setPrincipalImage($image);

        return $this;
    }
}
