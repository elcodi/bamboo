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
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Store\StoreProductBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\MediaBundle\Services\ImageManager;
use Elcodi\MediaBundle\Transformer\FileTransformer;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Gaufrette\Adapter;
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
         * GPB Currency
         */
        $currency = $this->container->get('elcodi.core.currency.factory.currency')->create();

        $currency->setSymbol('£');
        $currency->setIso('GBP');
        $currency->setEnabled(true);

        $manager->persist($currency);

        /**
         * @var ImageManager $imageManager
         * @var Adapter $filesystemAdapter
         * @var FileTransformer $fileTransformer
         */
        $imageManager = $this->container->get('elcodi.core.media.service.image_manager');
        $imageFactory = $this->container->get('elcodi.core.product.factory.product');
        $filesystemAdapter = $this->container->get('elcodi.core.media.filesystem.default')->getAdapter();
        $fileTransformer = $this->container->get('elcodi.core.media.transformer.file');

        /**
         * Ibiza Lips
         *
         * @var ProductInterface $product
         */
        $product = $imageFactory->create();
        $womenCategory = $this->getReference('category-women');
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
            ->setStock(30)
            ->setPrice(9.99)
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-ibiza-lips', $product);

        $this->storeImage($manager, $imageManager, $filesystemAdapter, $fileTransformer, $product, 'product-1.jpg');

        /**
         * Ibiza Banana
         *
         * @var ProductInterface $ibizaLipsProduct
         */
        $product = $imageFactory->create();
        $womenCategory = $this->getReference('category-women');
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
            ->setStock(30)
            ->setPrice(9.99)
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-ibiza-banana', $product);

        $this->storeImage($manager, $imageManager, $filesystemAdapter, $fileTransformer, $product, 'product-2.jpg');

        /**
         * I Was There
         *
         * @var ProductInterface $ibizaLipsProduct
         */
        $product = $imageFactory->create();
        $womenCategory = $this->getReference('category-women');
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
            ->setStock(30)
            ->setPrice(9.99)
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-i-was-there', $product);

        $this->storeImage($manager, $imageManager, $filesystemAdapter, $fileTransformer, $product, 'product-3.jpg');

        /**
         * A Life Style
         *
         * @var ProductInterface $ibizaLipsProduct
         */
        $product = $imageFactory->create();
        $womenCategory = $this->getReference('category-women');
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
            ->setStock(30)
            ->setPrice(9.99)
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-a-life-style', $product);

        $this->storeImage($manager, $imageManager, $filesystemAdapter, $fileTransformer, $product, 'product-4.jpg');

        /**
         * Amnesia
         *
         * @var ProductInterface $ibizaLipsProduct
         */
        $product = $imageFactory->create();
        $menCategory = $this->getReference('category-men');
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
            ->setStock(30)
            ->setPrice(9.99)
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-amnesia', $product);

        $this->storeImage($manager, $imageManager, $filesystemAdapter, $fileTransformer, $product, 'product-11.jpg');

        /**
         * All night long
         *
         * @var ProductInterface $ibizaLipsProduct
         */
        $product = $imageFactory->create();
        $menCategory = $this->getReference('category-men');
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
            ->setStock(30)
            ->setPrice(9.99)
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-all-night-long', $product);

        $this->storeImage($manager, $imageManager, $filesystemAdapter, $fileTransformer, $product, 'product-14.jpg');

        /**
         * High Pyramid
         *
         * @var ProductInterface $ibizaLipsProduct
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
            ->setStock(30)
            ->setPrice(9.99)
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-high-pyramid', $product);

        $this->storeImage($manager, $imageManager, $filesystemAdapter, $fileTransformer, $product, 'product-16.jpg');

        /**
         * Star Amnesia
         *
         * @var ProductInterface $ibizaLipsProduct
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
            ->setStock(30)
            ->setPrice(9.99)
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-star-amnesia', $product);

        $this->storeImage($manager, $imageManager, $filesystemAdapter, $fileTransformer, $product, 'product-17.jpg');

        /**
         * Ibiza 4 Ever
         *
         * @var ProductInterface $ibizaLipsProduct
         */
        $product = $imageFactory->create();
        $menCategory = $this->getReference('category-men');
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
            ->setStock(30)
            ->setPrice(9.99)
            ->setEnabled(true);

        $manager->persist($product);
        $this->addReference('product-ibiza-4-ever', $product);

        $this->storeImage($manager, $imageManager, $filesystemAdapter, $fileTransformer, $product, 'product-18.jpg');

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
     * @param ObjectManager $manager
     * @param $imageManager
     * @param $filesystemAdapter
     * @param $fileTransformer
     * @param $product
     * @param $imageName
     */
    protected function storeImage(ObjectManager $manager, $imageManager, $filesystemAdapter,
                                  $fileTransformer, $product, $imageName)
    {
        $imagePath = realpath(dirname(__FILE__) . '/images/' .$imageName);
        $image = $imageManager->createImage(new File($imagePath));
        $manager->persist($image);
        $manager->flush($image);

        if ($filesystemAdapter->exists($fileTransformer->transform($image))) {

            $filesystemAdapter->delete($fileTransformer->transform($image));
        }

        $filesystemAdapter->write(
            $fileTransformer->transform($image),
            file_get_contents($imagePath)
        );

        $product->addImage($image);
        $product->setPrincipalImage($image);
    }
}
