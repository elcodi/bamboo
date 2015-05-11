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

namespace Elcodi\Fixtures\DataFixtures\ORM\Base\Menu;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;

/**
 * Class Configuration
 *
 * @author Berny Cantos <be@rny.cc>
 */
class Configuration extends AbstractConfiguration
{
    /**
     * Configure the root node
     *
     * @param ArrayNodeDefinition $rootNode
     */
    protected function setupTree(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->children()
                    ->scalarNode('code')
                        ->isRequired()
                        ->cannotBeEmpty()
                    ->end()
                    ->scalarNode('description')
                        ->isRequired()
                        ->cannotBeEmpty()
                    ->end()
                    ->booleanNode('enabled')
                        ->defaultTrue()
                    ->end()
                    ->append($this->childNode('children'));
    }

    /**
     * Build configuration for a menu node
     *
     * @param ArrayNodeDefinition $node
     */
    protected function buildMenuNode(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('description')->end()

                ->scalarNode('name')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()

                ->scalarNode('url')
                    ->defaultNull()
                ->end()

                ->scalarNode('code')
                    ->defaultNull()
                ->end()

                ->arrayNode('active_urls')
                    ->defaultValue([])
                    ->prototype('scalar')
                        ->validate()
                            ->ifTrue(function ($item) {
                                return !is_string($item);
                            })
                            ->thenInvalid('Active urls must be string')
                        ->end()
                    ->end()
                ->end()

                ->booleanNode('enabled')
                    ->defaultTrue()
                ->end()

                ->append($this->childNode('children'))
            ->end();
    }

    /**
     * Configure a children node
     *
     * @param string $name Name of the node
     *
     * @return ArrayNodeDefinition
     */
    protected function childNode($name)
    {
        $treeBuild = new TreeBuilder();
        $root = $treeBuild->root($name, 'variable');

        $root
            ->defaultValue([])

            ->validate()
                ->ifTrue(function ($entry) {
                    return !is_array($entry);
                })
                ->thenInvalid('The "' . $name . '" element must be an array.')
            ->end()

            ->validate()
                ->always(function (array $children) {
                    $treeBuilder = new TreeBuilder();
                    $configuration = [];
                    foreach ($children as $name => $child) {
                        $node = $treeBuilder->root($name);

                        $this->buildMenuNode($node);

                        $config = $this->processConfig($node, $child);
                        $configuration[$name] = $config;
                    }

                    return $configuration;
                })
            ->end();

        return $root;
    }

    /**
     * Processes configuration through a node definition
     *
     * @param ArrayNodeDefinition $node   Definition for configuration
     * @param mixed               $config Configuration to process
     *
     * @return mixed
     */
    protected function processConfig(ArrayNodeDefinition $node, $config)
    {
        return $node
            ->getNode(true)
            ->finalize($config);
    }
}
