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

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ApiExtension
 */
class ApiExtension extends AbstractExtension
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'api';

    /**
     * Get the Config file location
     *
     * @return string Config file location
     */
    public function getConfigFilesLocation()
    {
        return __DIR__ . '/../Resources/config';
    }

    /**
     * Return a new Configuration instance.
     *
     * If object returned by this method is an instance of
     * ConfigurationInterface, extension will use the Configuration to read all
     * bundle config definitions.
     *
     * Also will call getParametrizationValues method to load some config values
     * to internal parameters.
     *
     * @return ConfigurationInterface Configuration file
     */
    protected function getConfigurationInstance()
    {
        return new Configuration(static::EXTENSION_NAME);
    }

    /**
     * Config files to load
     *
     * return array(
     *      'file1.yml',
     *      'file2.yml',
     *      ...
     * );
     *
     * @param array $config Configuration
     *
     * @return array Config files
     */
    public function getConfigFiles(array $config)
    {
        return [
            'services',
            'controllers',
            'eventDispatchers',

            'firewalls',
            'loaders',
            'decorators',
            'cleaners',
            'queryBuilderModifiers',
        ];
    }

    /**
     * Load Parametrization definition
     *
     * return array(
     *      'parameter1' => $config['parameter1'],
     *      'parameter2' => $config['parameter2'],
     *      ...
     * );
     *
     * @param array $config Bundles config values
     *
     * @return array Parametrization values
     */
    protected function getParametrizationValues(array $config)
    {
        return [
            'api_rest.route_format' => $config['route_format'],
            'api_rest.meta' => isset($config['meta']) ? $config['meta'] : [],
        ];
    }

    /**
     * Hook after load the full container.
     *
     * @param array            $config    Configuration
     * @param ContainerBuilder $container Container
     */
    protected function postLoad(array $config, ContainerBuilder $container)
    {
        $configurationDefinition = $container
            ->register(
                'api_rest.configuration',
                'ApiRest\Api\Configuration\ApiRestConfigurationCollector'
            )
            ->setArguments([
                 $config['route_format']
            ])
            ->setPublic(false);

        foreach ($config['entities'] as $entityConfiguration) {

            $container
                ->register(
                    'api_rest.configuration.' . $entityConfiguration['alias'],
                    'ApiRest\Api\Configuration\ApiRestConfiguration'
                )
                ->setArguments([
                    $entityConfiguration['enabled'],
                    $entityConfiguration['alias'],
                    $entityConfiguration['namespace'],
                    $entityConfiguration['level']
                ])
                ->setPublic(false);

            $configurationDefinition
                ->addMethodCall(
                    'addApiRestConfiguration',
                    [new Reference('api_rest.configuration.' . $entityConfiguration['alias'])]
                );
        }
    }

    /**
     * Returns the extension alias, same value as extension name
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return static::EXTENSION_NAME;
    }
}
