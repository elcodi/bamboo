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

namespace Elcodi\Store\ProductBundle\EventListener;

use Elcodi\Store\ProductBundle\Services\StoreCategoryTree;

class CategoriesOrderChangeEventListener
{
    /**
     * @var StoreCategoryTree
     *
     * A category tree service
     */
    private $storeCategoryTree;

    /**
     * Event listener responsible of listening the categories order change event and update store category tree
     *
     * @param StoreCategoryTree $storeCategoryTree A store category tree
     */
    public function __construct(StoreCategoryTree $storeCategoryTree)
    {
        $this->storeCategoryTree = $storeCategoryTree;
    }

    /**
     * This method is called every time that some property that could affect the categories tree is changed and it
     * reloads the full tree.
     */
    public function onChange()
    {
        $this->storeCategoryTree->reload();
    }
}
