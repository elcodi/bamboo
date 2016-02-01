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

namespace Elcodi\Admin\PageBundle\Builder;

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
            ->findSubnodeByName('admin.communication.single')
            ->addSubnode(
                $this
                    ->menuNodeFactory
                    ->create()
                    ->setName('admin.page.plural')
                    ->setCode('file-text-o')
                    ->setUrl('admin_page_list')
                    ->setActiveUrls([
                        'admin_page_edit',
                        'admin_page_new',
                    ])
            )
            ->addSubnode(
                $this
                    ->menuNodeFactory
                    ->create()
                    ->setName('admin.blog.single')
                    ->setCode('pencil')
                    ->setUrl('admin_blog_post_list')
                    ->setActiveUrls([
                        'admin_blog_post_edit',
                        'admin_blog_post_new',
                    ])
            )
            ->addSubnode(
                $this
                    ->menuNodeFactory
                    ->create()
                    ->setName('admin.mailing.plural')
                    ->setCode('envelope-o')
                    ->setUrl('admin_email_list')
                    ->setActiveUrls([
                        'admin_email_list',
                        'admin_email_edit',
                    ])
            );
    }
}
