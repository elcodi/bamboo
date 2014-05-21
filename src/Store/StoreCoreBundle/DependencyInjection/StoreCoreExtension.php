<?php

/**
 *  @header_placeholder
 */

namespace Store\StoreCoreBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

use Elcodi\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;

/**
 * Class StoreFrontExtension
 */
class StoreCoreExtension extends AbstractExtension
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
     * Config files to load
     *
     * @return array Config files
     */
    public function getConfigFiles()
    {
        return [
            'classes',
            'eventListeners',
        ];
    }

}
