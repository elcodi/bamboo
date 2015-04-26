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

namespace Elcodi\Admin\PluginBundle\Listener;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Menu\Event\Abstracts\AbstractMenuEvent;

/**
 * Class AddPluginToMenuListener
 *
 * @author Berny Cantos <be@rny.cc>
 */
class AddPluginToMenuListener
{
    /**
     * @var AbstractFactory
     *
     * Menu node factory
     */
    protected $factory;

    /**
     * @var array
     *
     * Plugins configuration
     */
    protected $plugins;

    /**
     * Constructor
     *
     * @param AbstractFactory $factory Menu node factory
     * @param array           $plugins Plugins configuration
     */
    public function __construct(AbstractFactory $factory, array $plugins)
    {
        $this->factory = $factory;
        $this->plugins = $plugins;
    }

    /**
     * Add a new menu entry for each enabled plugin
     *
     * @param AbstractMenuEvent $event
     */
    public function onMenuPostLoad(AbstractMenuEvent $event)
    {
        $plugins = $this->filterValidPlugins();

        if (empty($plugins)) {
            return;
        }

        foreach ($plugins as $plugin) {
            $menu = $this
                ->factory
                ->create()
                    ->setName($plugin['name'])
                    ->setCode($plugin['fa_icon'])
                    ->setUrl($plugin['configuration_route']);

            $event->addNode($menu);
        }
    }

    /**
     * Collect each valid plugin
     *
     * @return array
     */
    protected function filterValidPlugins()
    {
        return array_filter($this->plugins, function ($plugin) {

            return $plugin['enabled'] && $plugin['visible'];
        });
    }
}
