<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * This distribution is just a basic e-commerce implementation based on
 * Elcodi project.
 *
 * Feel free to edit it, and make your own
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
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
         * @var CurrencyInterface $currency
         */
        $currency = $this->container->get('elcodi.core.currency.factory.currency')->create();

        $currency
            ->setSymbol('$')
            ->setIso('USD');

        $manager->persist($currency);

        /**
         * @var ImageManager      $imageManager
         * @var Adapter           $filesystemAdapter
         * @var FileTransformer   $fileTransformer
         * @var CategoryInterface $menCategory
         * @var CategoryInterface $wemanCategory
         */
        $imageManager = $this->container->get('elcodi.core.media.service.image_manager');
        $imageFactory = $this->container->get('elcodi.core.product.factory.product');
        $filesystem = $this->container->get('elcodi.core.media.filesystem.default');
        $fileTransformer = $this->container->get('elcodi.core.media.transformer.file');
        $menCategory = $this->getReference('category-men');
        $womenCategory = $this->getReference('category-women');

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
            ->setPrice(new Money(399, $currency))
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

        /**
         * Barcelona Sun
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $womenCategory = $this->getReference('category-women');
        $product
            ->setName('Barcelona Sun')
            ->setSlug('barcelona-sun')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($womenCategory)
            ->setPrincipalCategory($womenCategory)
            ->setStock(10000)
            ->setPrice(new Money(1299, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-barcelona-sun', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-1.jpg');

        /**
         * Cervera style
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('Cervera Style')
            ->setSlug('cervera-style')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($womenCategory)
            ->setPrincipalCategory($womenCategory)
            ->setStock(10000)
            ->setPrice(new Money(1099, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-cervera-style', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-2.jpg');

        /**
         * Dance me now
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('Dance me now')
            ->setSlug('dance-me-now')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($womenCategory)
            ->setPrincipalCategory($womenCategory)
            ->setStock(10000)
            ->setPrice(new Money(3105, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-dance-me-now', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-3.jpg');

        /**
         * Sigues feliç
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('Sigues feliç')
            ->setSlug('sigues-felic')
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
        $this->addReference('product-sigues-feliç', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-4.jpg');

        /**
         * Sempre més
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('Sempre més')
            ->setSlug('sempre-mes')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setStock(10000)
            ->setPrice(new Money(1000, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-sempre-mes', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-11.jpg');

        /**
         * Because yes
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('Because yes')
            ->setSlug('because-yes')
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
        $this->addReference('product-because-yes', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-14.jpg');

        /**
         * Parada de xurros
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('Parada de xurros')
            ->setSlug('parada-de-xurros')
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
        $this->addReference('product-parada-de-xurros', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-16.jpg');

        /**
         * Keep calm and engonga
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('Keem calm and engonga')
            ->setSlug('keep-calm-and-engonga')
            ->setDescription(
                'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.'
            )
            ->addCategory($menCategory)
            ->setPrincipalCategory($menCategory)
            ->setStock(10000)
            ->setPrice(new Money(5000, $currency))
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-keep-calm-and-engonga', $product);

        $this->storeImage($manager, $imageManager, $filesystem, $fileTransformer, $product, 'product-17.jpg');

        /**
         * Equip màgic
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $product
            ->setName('Equip màgic')
            ->setSlug('equip-magic')
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
        $this->addReference('product-equip-magic', $product);

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
