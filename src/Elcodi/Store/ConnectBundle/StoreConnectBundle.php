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

namespace Elcodi\Store\ConnectBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

use Elcodi\Bundle\CoreBundle\Abstracts\AbstractElcodiBundle;
use Elcodi\Store\ConnectBundle\CompilerPass\MappingCompilerPass;
use Elcodi\Store\ConnectBundle\DependencyInjection\StoreConnectExtension;

/**
 * Class StoreConnectBundle
 *
 * @author Berny Cantos <be@rny.cc>
 */
class StoreConnectBundle extends AbstractElcodiBundle
{
    /**
     * Builds the bundle.
     *
     * It is only ever called once when the cache is empty.
     *
     * This method can be overridden to register compilation passes,
     * other extensions, ...
     *
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new MappingCompilerPass());
    }

    /**
     * Returns the bundle's container extension.
     *
     * @return ExtensionInterface The container extension
     */
    public function getContainerExtension()
    {
        return new StoreConnectExtension();
    }
}
