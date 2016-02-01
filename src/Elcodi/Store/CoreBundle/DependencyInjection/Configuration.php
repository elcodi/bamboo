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

namespace Elcodi\Store\CoreBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\HttpFoundation\Response;

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
        $templateValidation = function ($value) {
            if (is_string($value)) {
                return $value;
            }

            throw new \InvalidArgumentException(sprintf(
                'Status templates must be strings, "%s" found',
                $value
            ));
        };

        $checkForNumeric = function ($value) {
            if (is_numeric($value)) {
                return $value;
            }

            throw new \InvalidArgumentException(sprintf(
                'Status code for error templates must be numeric, "%s" found',
                $value
            ));
        };

        $checkForNumericKeys = function (array $value) {
            foreach ($value as $code => $template) {
                if (!is_numeric($code)) {
                    throw new \InvalidArgumentException(sprintf(
                        'Status codes for error templates must be numeric, "%s" found',
                        $code
                    ));
                }
            }

            return $value;
        };

        $rootNode
            ->children()

                ->arrayNode('error_templates')
                    ->info('Error templates setup')
                    ->canBeEnabled()

                    ->children()
                        ->scalarNode('default')
                            ->info('Default template for exceptions')
                            ->defaultValue('Exception:error.html.twig')

                            ->validate()
                                ->always($templateValidation)
                            ->end()
                        ->end()

                        ->arrayNode('by_code')
                            ->info('Specific template by status code')
                            ->example('{ 404: Exception:error.html.twig }')
                            ->useAttributeAsKey('name')

                            ->prototype('scalar')
                                ->validate()
                                    ->ifTrue(function ($value) { return null !== $value; })
                                    ->then($templateValidation)
                                ->end()
                            ->end()

                            ->validate()
                                ->always($checkForNumericKeys)
                            ->end()
                        ->end()

                        ->scalarNode('fallback')
                            ->info('Default status code for non-http exceptions')
                            ->defaultFalse()
                            ->treatTrueLike(Response::HTTP_INTERNAL_SERVER_ERROR)

                            ->validate()
                                ->always($checkForNumeric)
                            ->end()
                        ->end()

                    ->end()
                ->end()
            ->end();
    }
}
