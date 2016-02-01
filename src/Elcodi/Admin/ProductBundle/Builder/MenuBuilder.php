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

namespace Elcodi\Admin\ProductBundle\Builder;

use Elcodi\Component\Menu\Builder\Abstracts\AbstractMenuBuilder;
use Elcodi\Component\Menu\Builder\Interfaces\MenuBuilderInterface;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface;

/**
 * Class MenuBuilder
 */
class MenuBuilder extends AbstractMenuBuilder implements MenuBuilderInterface
{
    /**
     * Build the menu
     *
     * @param MenuInterface $menu Menu
     */
    public function build(MenuInterface $menu)
    {
        $menu
            ->addSubnode(
                $this
                    ->menuNodeFactory
                    ->create()
                    ->setName('admin.product.plural')
                    ->setCode('barcode')
                    ->setUrl('admin_product_list')
                    ->setTag('catalog')
                    ->setPriority(35)
                    ->setActiveUrls([
                        'admin_product_edit',
                        'admin_product_new',
                    ])
            )
            ->addSubnode(
                $this
                    ->menuNodeFactory
                    ->create()
                    ->setName('admin.purchasable_pack.plural')
                    ->setCode('archive')
                    ->setUrl('admin_purchasable_pack_list')
                    ->setTag('catalog')
                    ->setPriority(33)
                    ->setActiveUrls([
                        'admin_purchasable_pack_edit',
                        'admin_purchasable_pack_new',
                    ])
            )
            ->addSubnode(
                $this
                    ->menuNodeFactory
                    ->create()
                    ->setName('admin.categorization.single')
                    ->setCode('tag')
                    ->setTag('catalog')
                    ->setPriority(30)
                    ->addSubnode(
                        $this
                            ->menuNodeFactory
                            ->create()
                            ->setName('admin.attribute.plural')
                            ->setUrl('admin_attribute_list')
                            ->setActiveUrls([
                                'admin_attribute_edit',
                                'admin_attribute_new',
                            ])
                    )
                    ->addSubnode(
                        $this
                            ->menuNodeFactory
                            ->create()
                            ->setName('admin.manufacturer.plural')
                            ->setUrl('admin_manufacturer_list')
                            ->setActiveUrls([
                                'admin_manufacturer_edit',
                                'admin_manufacturer_new',
                            ])
                    )
                    ->addSubnode(
                        $this
                            ->menuNodeFactory
                            ->create()
                            ->setName('admin.category.plural')
                            ->setUrl('admin_category_list')
                            ->setActiveUrls([
                                'admin_category_edit',
                                'admin_category_new',
                            ])
                    )
            );
    }
}
