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

namespace Elcodi\Admin\ProductBundle\EventListener;

use Doctrine\ORM\Event\PreFlushEventArgs;

use Elcodi\Component\Product\Entity\Category;

/**
 * Class NewCategoryPositionEventListener sets the position for new categories when these are inserted.
 */
class NewCategoryPositionEventListener
{
    /**
     * Before the flush we check if we are inserting new categories and in this case we set a correct position.
     *
     * @param PreFlushEventArgs $args The pre flush event arguments.
     */
    public function preFlush(PreFlushEventArgs $args)
    {
        $entityManager = $args->getEntityManager();
        $scheduledInsertions = $entityManager->getUnitOfWork()->getScheduledEntityInsertions();

        foreach ($scheduledInsertions as $entity) {
            if ($entity instanceof Category) {
                /**
                 * @var Category $entity
                 */
                $entityRepository = $entityManager->getRepository(get_class($entity));

                if ($entity->isRoot()) {
                    $parentCategoriesNumber = count($entityRepository->getParentCategories());
                    $entity->setPosition($parentCategoriesNumber);
                } else {
                    $categoriesOnThisParentCategory = count($entityRepository->getChildrenCategories(
                        $entity->getParent()
                    ));
                    $entity->setPosition($categoriesOnThisParentCategory);
                }
            }
        }
    }
}
