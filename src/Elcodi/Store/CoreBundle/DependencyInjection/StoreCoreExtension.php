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

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;

/**
 * Class StoreFrontExtension
 */
class StoreCoreExtension extends AbstractExtension
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'store_core';

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
     * @return Configuration Configuration file
     */
    protected function getConfigurationInstance()
    {
        return new Configuration($this->getAlias());
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
     * @param array $config Config
     *
     * @return array Config files
     */
    public function getConfigFiles(array $config)
    {
        return [
            'eventListeners',
            'twig',
            'services',
            [ 'exceptions', $config['error_templates']['enabled'] ],
        ];
    }

    /**
     * Hook after pre-pending configuration.
     *
     * @param array            $config    Configuration
     * @param ContainerBuilder $container Container
     */
    protected function preLoad(array $config, ContainerBuilder $container)
    {
        parent::preLoad($config, $container);

        if ($config['error_templates']['enabled']) {
            $container->prependExtensionConfig('twig', [
                'exception_controller' => 'elcodi_store.exception_controller:showAction',
            ]);
        }
    }

    /**
     * Hook after load the full container
     *
     * @param array            $config    Configuration
     * @param ContainerBuilder $container Container
     */
    protected function postLoad(array $config, ContainerBuilder $container)
    {
        parent::postLoad($config, $container);

        $this->setupExceptions($config['error_templates'], $container);
    }

    /**
     * Setup exception listener
     *
     * @param array            $config
     * @param ContainerBuilder $container
     *
     * @return null
     */
    protected function setupExceptions(array $config, ContainerBuilder $container)
    {
        $serviceId = 'elcodi_store.exception_controller';
        if (!$container->hasDefinition($serviceId)) {
            return null;
        }

        $container
            ->getDefinition($serviceId)
            ->addArgument($config['default'])
            ->addArgument($config['by_code'])
            ->addArgument($config['fallback']);
    }

    /**
     * Returns the extension alias, same value as extension name
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return self::EXTENSION_NAME;
    }
}
