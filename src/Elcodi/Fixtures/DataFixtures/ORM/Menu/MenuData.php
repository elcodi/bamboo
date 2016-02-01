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

namespace Elcodi\Fixtures\DataFixtures\ORM\Menu;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Config\Definition\Processor;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * Class MenuData
 *
 * Fixtures for Bamboo menus
 */
class MenuData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $director = $this->get('elcodi.director.menu');

        $menu = $director
            ->create()
            ->setCode('admin')
            ->setDescription('Admin menu')
            ->setEnabled(true);

        $director->save($menu);
    }
}
