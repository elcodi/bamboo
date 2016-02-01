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

namespace Elcodi\Admin\CoreBundle\Builder;

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
                    ->setName('admin.dashboard.single')
                    ->setCode('dashboard')
                    ->setUrl('admin_homepage')
                    ->setTag('dashboard')
                    ->setActiveUrls([
                        'admin_reports_today',
                        'admin_reports_yesterday',
                        'admin_reports_last_week',
                        'admin_reports_last_month',
                        'admin_reports_last_quarter',
                    ])
            )
            ->addSubnode(
                $this
                    ->menuNodeFactory
                    ->create()
                    ->setName('admin.communication.single')
                    ->setCode('bullhorn')
                    ->setTag('communication')
            )
            ->addSubnode(
                $this
                    ->menuNodeFactory
                    ->create()
                    ->setName('admin.menu.design')
                    ->setCode('adjust')
                    ->setTag('design')
            )
            ->addSubnode(
                $this
                    ->menuNodeFactory
                    ->create()
                    ->setName('admin.settings.plural')
                    ->setCode('gear')
                    ->setTag('settings')
                    ->setPriority(-32)
            );
    }
}
