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

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Elcodi\Component\Menu\Builder\Interfaces\MenuBuilderInterface;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface;
use Elcodi\Component\Menu\Factory\NodeFactory;
use Elcodi\Component\Plugin\Entity\Plugin;

/**
 * Class PluginMenuBuilder
 */
class PluginMenuBuilder implements MenuBuilderInterface
{
    /**
     * @var NodeFactory
     *
     * Menu node factory
     */
    protected $menuNodeFactory;

    /**
     * @var UrlGeneratorInterface
     *
     * Url generator
     */
    protected $urlGenerator;

    /**
     * @var Plugin[]
     *
     * Plugins configuration
     */
    protected $enabledPlugins;

    /**
     * Constructor
     *
     * @param NodeFactory           $menuNodeFactory Menu node factory
     * @param UrlGeneratorInterface $urlGenerator    Url generator
     * @param array                 $enabledPlugins  Enabled Plugins
     */
    public function __construct(
        NodeFactory $menuNodeFactory,
        UrlGeneratorInterface $urlGenerator,
        array $enabledPlugins
    ) {
        $this->menuNodeFactory = $menuNodeFactory;
        $this->urlGenerator = $urlGenerator;
        $this->enabledPlugins = $enabledPlugins;
    }

    /**
     * Build the menu
     *
     * @param MenuInterface $menu Menu
     */
    public function build(MenuInterface $menu)
    {
        $visiblePlugins = $this->filterVisiblePlugins();

        foreach ($visiblePlugins as $visiblePlugin) {
            $pluginConfigurationRoute = $this
                ->urlGenerator
                ->generate('admin_plugin_configure', [
                    'pluginHash' => $visiblePlugin->getHash(),
                ]);

            $menuNode = $this
                ->menuNodeFactory
                ->create()
                ->setName($visiblePlugin->getConfigurationValue('name'))
                ->setCode($visiblePlugin->getConfigurationValue('fa_icon'))
                ->setUrl($pluginConfigurationRoute)
                ->setTag('extra')
                ->setEnabled(true);

            $menu
                ->findSubnodeByName('admin.plugin.plural')
                ->addSubnode($menuNode);
        }
    }

    /**
     * Return only visible plugins
     *
     * @return Plugin[] Visible plugins
     */
    protected function filterVisiblePlugins()
    {
        return array_filter(
            $this->enabledPlugins,
            function (Plugin $plugin) {

                return
                    $plugin->getConfigurationValue('visible') &&
                    $plugin->hasFields();
            }
        );
    }
}
