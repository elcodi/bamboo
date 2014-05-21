<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  * @version
 */

namespace Elcodi\StoreProductBundle\DataFixtures\ORM;

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
         * @var ImageManager $imageManager
         * @var Adapter $filesystemAdapter
         * @var FileTransformer $fileTransformer
         */
        $imageManager = $this->container->get('elcodi.core.media.services.image_manager');
        $imageFactory = $this->container->get('elcodi.core.product.factory.product');
        $filesystemAdapter = $this->container->get('elcodi.core.media.filesystem.default')->getAdapter();
        $fileTransformer = $this->container->get('elcodi.core.media.transformer.file');

        /**
         * Ibiza Lips
         *
         * @var ProductInterface $ibizaLipsProduct
         */
        $ibizaLipsProduct = $imageFactory->create();
        $womenCategory = $this->getReference('category-women');
        $ibizaLipsProduct
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

        $manager->persist($ibizaLipsProduct);
        $this->addReference('product-ibiza-lips', $ibizaLipsProduct);

        $this->storeImage($manager, $imageManager, $filesystemAdapter, $fileTransformer, $ibizaLipsProduct, 'product-1.jpg');

        /**
         * Ibiza Banana
         *
         * @var ProductInterface $ibizaLipsProduct
         */
        $ibizaLipsProduct = $imageFactory->create();
        $womenCategory = $this->getReference('category-women');
        $ibizaLipsProduct
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

        $manager->persist($ibizaLipsProduct);
        $this->addReference('product-ibiza-banana', $ibizaLipsProduct);

        $this->storeImage($manager, $imageManager, $filesystemAdapter, $fileTransformer, $ibizaLipsProduct, 'product-2.jpg');

        /**
         * I Was There
         *
         * @var ProductInterface $ibizaLipsProduct
         */
        $ibizaLipsProduct = $imageFactory->create();
        $womenCategory = $this->getReference('category-women');
        $ibizaLipsProduct
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

        $manager->persist($ibizaLipsProduct);
        $this->addReference('product-i-was-there', $ibizaLipsProduct);

        $this->storeImage($manager, $imageManager, $filesystemAdapter, $fileTransformer, $ibizaLipsProduct, 'product-3.jpg');

        /**
         * A Life Style
         *
         * @var ProductInterface $ibizaLipsProduct
         */
        $ibizaLipsProduct = $imageFactory->create();
        $womenCategory = $this->getReference('category-women');
        $ibizaLipsProduct
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

        $manager->persist($ibizaLipsProduct);
        $this->addReference('product-a-life-style', $ibizaLipsProduct);

        $this->storeImage($manager, $imageManager, $filesystemAdapter, $fileTransformer, $ibizaLipsProduct, 'product-4.jpg');

        /**
         * Amnesia
         *
         * @var ProductInterface $ibizaLipsProduct
         */
        $ibizaLipsProduct = $imageFactory->create();
        $menCategory = $this->getReference('category-men');
        $ibizaLipsProduct
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

        $manager->persist($ibizaLipsProduct);
        $this->addReference('product-amnesia', $ibizaLipsProduct);

        $this->storeImage($manager, $imageManager, $filesystemAdapter, $fileTransformer, $ibizaLipsProduct, 'product-11.jpg');

        /**
         * All night long
         *
         * @var ProductInterface $ibizaLipsProduct
         */
        $ibizaLipsProduct = $imageFactory->create();
        $menCategory = $this->getReference('category-men');
        $ibizaLipsProduct
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

        $manager->persist($ibizaLipsProduct);
        $this->addReference('product-all-night-long', $ibizaLipsProduct);

        $this->storeImage($manager, $imageManager, $filesystemAdapter, $fileTransformer, $ibizaLipsProduct, 'product-14.jpg');

        /**
         * High Pyramid
         *
         * @var ProductInterface $ibizaLipsProduct
         */
        $ibizaLipsProduct = $imageFactory->create();
        $menCategory = $this->getReference('category-men');
        $ibizaLipsProduct
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

        $manager->persist($ibizaLipsProduct);
        $this->addReference('product-high-pyramid', $ibizaLipsProduct);

        $this->storeImage($manager, $imageManager, $filesystemAdapter, $fileTransformer, $ibizaLipsProduct, 'product-16.jpg');

        /**
         * Ibiza 4 Ever
         *
         * @var ProductInterface $ibizaLipsProduct
         */
        $ibizaLipsProduct = $imageFactory->create();
        $menCategory = $this->getReference('category-men');
        $ibizaLipsProduct
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

        $manager->persist($ibizaLipsProduct);
        $this->addReference('product-ibiza-4-ever', $ibizaLipsProduct);

        $this->storeImage($manager, $imageManager, $filesystemAdapter, $fileTransformer, $ibizaLipsProduct, 'product-18.jpg');



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
