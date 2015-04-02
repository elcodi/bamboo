<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Common\ConfigurationBundle;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use Elcodi\Common\ConfigurationBundle\DependencyInjection\ConfigurationExtension;

/**
 * Class ConfigurationAnnotationBundle
 *
 * @author Berny Cantos <be@rny.cc>
 */
class ConfigurationAnnotationBundle extends Bundle
{
    /**
     * Returns the bundle's container extension.
     *
     * @return ConfigurationExtension The container extension
     */
    public function getContainerExtension()
    {
        return new ConfigurationExtension();
    }

    /**
     * Boots the Bundle.
     */
    public function boot()
    {
        parent::boot();

        AnnotationRegistry::registerFile(__DIR__ . '/Annotation/Configuration.php');
    }
}
