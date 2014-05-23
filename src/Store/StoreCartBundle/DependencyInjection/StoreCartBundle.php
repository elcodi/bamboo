<?php

/**
 * This file is part of the Controller Extra Bundle
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @since 2013
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Store\StoreCartBundle\DependencyInjection;

use Elcodi\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;

/**
 * Class StoreCartBundle
 */
class StoreCartBundle extends AbstractExtension
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
     * return array(
     *      'file1.yml',
     *      'file2.yml',
     *      ...
     * );
     *
     * @return array Config files
     */
    public function getConfigFiles()
    {
        return [];
    }
}
