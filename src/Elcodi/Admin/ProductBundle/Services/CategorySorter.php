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

namespace Elcodi\Admin\ProductBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Elcodi\Component\Product\Entity\Category;
use Elcodi\Component\Product\Repository\CategoryRepository;

/**
 * Class CategorySorter
 */
class CategorySorter
{
    /**
     * @var CategoryRepository
     *
     * Category entity repository.
     */
    private $categoryRepository;

    /**
     * @var ObjectManager
     *
     * Category entity object manager.
     */
    private $categoryObjectManager;

    /**
     * @var EventDispatcherInterface
     *
     * An event dispatcher instance.
     */
    private $eventDispatcher;

    /**
     * Builds a new category order service.
     *
     * @param CategoryRepository       $categoryRepository    The category repository
     * @param ObjectManager            $categoryObjectManager The category object manager
     * @param EventDispatcherInterface $eventDispatcher       An event dispatcher instance
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        ObjectManager $categoryObjectManager,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->categoryRepository    = $categoryRepository;
        $this->categoryObjectManager = $categoryObjectManager;
        $this->eventDispatcher       = $eventDispatcher;
    }

    /**
     * Sort the received categories based on the received order.
     * The order is received on the following format:
     *
     * [
     *      [
     *          'id'      => xx,
     *          'subtree' => [
     *              'id'      => xx,
     *              'subtree' => []
     *          ]
     *      ],
     *      [
     *          'id'      => xx,
     *          'subtree' => [
     *              [
     *                  'id'      => xx,
     *                  'subtree' => [
     *                      'id'      => xx,
     *                      'subtree' => []
     *                  ]
     *              ]
     *          ]
     *      ],
     * ]
     *
     * @param array $categoriesOrder The category order (See function comment)
     *
     * @return bool If the order process has finished right.
     */
    public function sort(array $categoriesOrder)
    {
        if ($this->sortCategoriesTree($categoriesOrder)) {
            $this
                ->categoryObjectManager
                ->flush();

            return true;
        }

        return false;
    }

    /**
     * Sort a category tree based on the received order recursively.
     *
     * @param array         $categoriesOrder The category order
     * @param Category|null $parentCategory  The parent category in case is not a root category.
     *
     * @return bool If the order process has finished right.
     */
    protected function sortCategoriesTree(array $categoriesOrder, $parentCategory = null)
    {
        $counter = 0;
        foreach ($categoriesOrder as $categoryInfo) {
            $category = $this->categoryRepository->findOneBy([
                'id' => $categoryInfo['id'],
            ]);

            if (is_null($category)) {
                return false;
            }

            $category->setPosition($counter);

            if ($parentCategory) {
                $category->setPosition($counter);
                $category->setRoot(false);
                $category->setParent($parentCategory);
            } else {
                $category->setPosition($counter);
                $category->setRoot(true);
                $category->setParent(null);
            }

            ++$counter;

            if (
                isset($categoryInfo['subtree']) &&
                !$this->sortCategoriesTree($categoryInfo['subtree'], $category)
            ) {
                return false;
            }
        }

        return true;
    }
}
