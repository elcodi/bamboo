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
 */

namespace Elcodi\Store\CoreBundle\DependencyInjection;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

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
            ->children()
                ->arrayNode('errors')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->append($this->template('not_found'))
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * Create a node to define a template
     *
     * @param string $name Node name
     * @param string $template Default template path
     *
     * @return ArrayNodeDefinition|NodeDefinition
     */
    protected function template($name, $template = 'TwigBundle:Exception:error.html.twig')
    {
        $root = new TreeBuilder();
        $node = $root->root($name);

        $node
            ->addDefaultsIfNotSet()
            ->treatFalseLike(array('enabled' => false))
            ->children()
                ->booleanNode('enabled')
                    ->defaultTrue()
                ->end()
                ->scalarNode('template')
                    ->defaultValue($template)
                ->end()
            ->end()
        ->end();

        return $node;
    }
}
