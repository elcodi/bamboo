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
        $plugin = $menu->findSubnodeByName('plugin_type.social');
        if ($plugin) {
            $plugin
                ->addSubnode(
                    $this
                        ->menuNodeFactory
                        ->create()
                        ->setName('admin.plugin.social_store')
                        ->setUrl('admin_plugin_social_list')
                        ->setPriority(9999)
                );
        }

        $plugin = $menu->findSubnodeByName('plugin_type.payment');
        if ($plugin) {
            $plugin
                ->addSubnode(
                    $this
                        ->menuNodeFactory
                        ->create()
                        ->setName('admin.plugin.payment_store')
                        ->setUrl('admin_plugin_payment_list')
                        ->setPriority(9999)
                );
        }

        $plugin = $menu->findSubnodeByName('plugin_type.shipping');
        if ($plugin) {
            $plugin
                ->addSubnode(
                    $this
                        ->menuNodeFactory
                        ->create()
                        ->setName('admin.plugin.shipping_store')
                        ->setUrl('admin_plugin_shipping_list')
                        ->setPriority(9999)
                );
        }
    }
}
