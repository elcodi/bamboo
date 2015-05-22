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

namespace Elcodi\Admin\ProductBundle\EventListener;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;

/**
 * Class ProductHasOnlyOneCategoryEventListener
 */
class ProductHasOnlyOneCategoryEventListener
{
    /**
     * This method checks that when when a new product is created the only
     * category assigned is the one selected as principal category.
     *
     * @param PreFlushEventArgs $args The pre flush event args.
     */
    public function preFlush(PreFlushEventArgs $args)
    {
        $entityManager = $args->getEntityManager();
        $scheduledInsertions = $entityManager
            ->getUnitOfWork()
            ->getScheduledEntityInsertions();

        foreach ($scheduledInsertions as $entity) {
            if ($entity instanceof ProductInterface) {
                $this->fixProductCategory($entity);
            }
        }
    }

    /**
     * This method ensures that when a product is modified the only category
     * assigned is the one selected as principal category.
     *
     * @param PreUpdateEventArgs $event The pre update event args.
     */
    public function preUpdate(PreUpdateEventArgs $event)
    {
        $entity = $event->getEntity();
        if ($entity instanceof ProductInterface) {
            $this->fixProductCategory($entity);
        }
    }

    /**
     * Overrides the product categories assigning the one saved as principal
     * category.
     *
     * @param ProductInterface $product The product being saved
     */
    protected function fixProductCategory(ProductInterface $product)
    {
        $principalCategory = $product->getPrincipalCategory();

        if ($principalCategory instanceof CategoryInterface) {
            $categories = new ArrayCollection();
            $categories->add($principalCategory);
            $product->setCategories($categories);
        }
    }
}
