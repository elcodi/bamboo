<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * This distribution is just a basic e-commerce implementation based on
 * Elcodi project.
 *
 * Feel free to edit it, and make your own
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Store\StoreProductBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Class Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('store_product');

        $rootNode
            ->children()
                ->arrayNode('menu')
                    ->addDefaultsIfNotSet()
                     ->children()
                        ->scalarNode('menu_cache_key')
                            ->defaultValue('tree')
                        ->end()
                     ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
