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

namespace Elcodi\Admin\PluginBundle\Builder;

use Elcodi\Component\Menu\Builder\Abstracts\AbstractMenuBuilder;
use Elcodi\Component\Menu\Builder\Interfaces\MenuBuilderInterface;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface;

/**
 * Class PluginCategoryMenuBuilder
 */
class PluginCategoryMenuBuilder extends AbstractMenuBuilder implements MenuBuilderInterface
{
    /**
     * Build the menu
     *
     * @param MenuInterface $menu Menu
     */
    public function build(MenuInterface $menu)
    {
        $menu
            ->findSubnodeByName('plugin_type.social')
            ->addSubnode(
                $this
                    ->menuNodeFactory
                    ->create()
                    ->setName('admin.plugin.social_store')
                    ->setUrl([
                        'admin_plugin_categorized_list', [
                            'category' => 'social',
                        ],
                    ])
                    ->setPriority(9999)
            );

        $menu
            ->findSubnodeByName('plugin_type.payment')
            ->addSubnode(
                $this
                    ->menuNodeFactory
                    ->create()
                    ->setName('admin.plugin.payment_store')
                    ->setUrl([
                        'admin_plugin_categorized_list', [
                            'category' => 'payment',
                        ],
                    ])
                    ->setPriority(9999)
            );

        $menu
            ->findSubnodeByName('plugin_type.shipping')
            ->addSubnode(
                $this
                    ->menuNodeFactory
                    ->create()
                    ->setName('admin.plugin.shipping_store')
                    ->setUrl([
                        'admin_plugin_categorized_list', [
                            'category' => 'shipping',
                        ],
                    ])
                    ->setPriority(9999)
            );
    }
}
