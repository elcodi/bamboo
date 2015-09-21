<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
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

namespace ApiRest\ApiBundle\DependencyInjection;

use ApiRest\Api\ApiRoutes;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 */
class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('api');

        $rootNode
            ->children()
                ->scalarNode('route_format')
                    ->defaultValue('api_{entity}_{verb}')
                ->end()
                ->arrayNode('entities')
                    ->prototype('array')
                        ->beforeNormalization()
                            ->ifString()
                            ->then(function ($value) {
                                return ['namespace' => $value];
                            })
                        ->end()
                        ->children()
                            ->booleanNode('enabled')
                                ->defaultTrue()
                            ->end()
                            ->scalarNode('namespace')
                                ->isRequired()
                            ->end()
                            ->arrayNode('verbs')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->booleanNode('get')
                                        ->defaultTrue()
                                    ->end()
                                    ->booleanNode('post')
                                        ->defaultTrue()
                                    ->end()
                                    ->booleanNode('put')
                                        ->defaultTrue()
                                    ->end()
                                    ->booleanNode('delete')
                                        ->defaultTrue()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->validate()
                        ->always()
                            ->then(function($entity) {

                                $level = 0;
                                $verbs = $entity['verbs'];

                                /**
                                 * build level given verbs
                                 */
                                if ($verbs['get']) {
                                    $level |= ApiRoutes::API_GET;
                                }

                                if ($verbs['post']) {
                                    $level |= ApiRoutes::API_POST;
                                }

                                if ($verbs['put']) {
                                    $level |= ApiRoutes::API_PUT;
                                }

                                if ($verbs['delete']) {
                                    $level |= ApiRoutes::API_DELETE;
                                }

                                $entity['level'] = $level;
                                unset($entity['verbs']);

                                return $entity;
                            })
                        ->end()
                    ->end()
                    ->validate()
                    ->always()
                        ->then(function($entities) {

                            /**
                             * Set alias if none is defined
                             */
                            foreach ($entities as $entityAlias => $entity) {
                                $entities[$entityAlias]['alias'] = $entityAlias;
                            }

                            return $entities;
                        })
                    ->end()
                ->end()
                ->variableNode('meta')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
