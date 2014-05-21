<?php

/**
 *  @header_placeholder
 */

namespace Store\StoreProductBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

use Elcodi\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;

/**
 * Class StoreFrontExtension
 */
class StoreProductExtension extends AbstractExtension
{
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
        return new Configuration();
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
            'store.product.menu_cache_key' => $config['menu']['menu_cache_key'],
        ];
    }

    /**
     * Config files to load
     *
     * @return array Config files
     */
    public function getConfigFiles()
    {
        return [
            'classes',
            'services',
        ];
    }
}
