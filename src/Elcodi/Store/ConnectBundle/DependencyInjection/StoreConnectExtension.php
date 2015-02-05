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

namespace Elcodi\Store\ConnectBundle\DependencyInjection;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * Class StoreConnectExtension
 *
 * @author Berny Cantos <be@rny.cc>
 */
class StoreConnectExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'store_connect';

    /**
     * @return string
     */
    public function getConfigFilesLocation()
    {
        return __DIR__.'/../Resources/config';
    }

    /**
     * @return Configuration
     */
    protected function getConfigurationInstance()
    {
        return new Configuration(static::EXTENSION_NAME);
    }

    /**
     * @param array $config
     *
     * @return array
     */
    protected function getParametrizationValues(array $config)
    {
        return [
            'store.connect.entity.authorization.class' => $config['mapping']['authorization']['class'],
            'store.connect.entity.authorization.mapping_file' => $config['mapping']['authorization']['mapping_file'],
            'store.connect.entity.authorization.manager' => $config['mapping']['authorization']['manager'],
            'store.connect.entity.authorization.enabled' => $config['mapping']['authorization']['enabled'],
        ];
    }

    /**
     * @param array $config
     *
     * @return array
     */
    public function getConfigFiles(array $config)
    {
        return [
            'classes',
            'objectManagers',
            'repositories',
            'services',
        ];
    }

    /**
     * @return array
     */
    public function getEntitiesOverrides()
    {
        return [
            'Elcodi\Store\ConnectBundle\Entity\AuthorizationInterface' => 'store.connect.entity.authorization.class',
        ];
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
