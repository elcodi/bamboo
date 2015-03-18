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

namespace Elcodi\Store\CoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

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
            'classes',
            'eventListeners',
            'twig',
            'services',
            [ 'exceptions', $this->shouldActivateExceptions($config) ],
        ];
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

        $serviceId = 'store.core.event_listener.exception';
        if ($container->hasDefinition($serviceId)) {
            $exceptions = $this->collectExceptions($config['errors']);
            $container
                ->getDefinition($serviceId)
                ->replaceArgument(2, $exceptions);
        }
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

        if ($this->shouldActivateInternalExceptions($config)) {
            $container->prependExtensionConfig('twig', [
                'exception_controller' => 'store.core.event_listener.exception:showExceptionAction',
            ]);
        }
    }

    /**
     * Check if the exception listener should be activated
     *
     * @param array $config Configuration
     *
     * @return bool
     */
    protected function shouldActivateExceptions(array $config)
    {
        foreach ($config['errors'] as $statusCode => $codeSetup) {
            if ($codeSetup['enabled']) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the exception listener for internal errors should be activated
     *
     * @param array $config Configuration
     *
     * @return bool
     */
    protected function shouldActivateInternalExceptions(array $config)
    {
        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        if (!isset($config['errors'][$statusCode])) {
            return false;
        }

        return $config['errors'][$statusCode]['enabled'];
    }

    /**
     * Check if the exception listener should be activated
     *
     * @param array $errors
     *
     * @return bool
     */
    protected function collectExceptions(array $errors)
    {
        $exceptions = [];
        foreach ($errors as $statusCode => $config) {

            if (!$config['enabled']) {
                continue;
            }

            $exceptions["{$statusCode}"] = $config['template'];
        }

        return $exceptions;
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
