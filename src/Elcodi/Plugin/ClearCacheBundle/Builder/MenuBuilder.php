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
 * @author Maksim <kodermax@gmail.com>
 */

namespace Elcodi\Plugin\ClearCacheBundle\Builder;

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
                    ->setName('plugin_type.utility')
                    ->setTag('settings')
                    ->setPriority(31)
                    ->addSubnode(
                        $this
                            ->menuNodeFactory
                            ->create()
                            ->setName('elcodi_plugin.clear_cache.name')
                            ->setUrl('admin_clear_cache_index')
                            ->setActiveUrls([
                                'admin_clear_cache_index',
                            ])
                    )
            );
    }
}
