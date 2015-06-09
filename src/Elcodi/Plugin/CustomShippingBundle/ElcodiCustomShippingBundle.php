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

namespace Elcodi\Plugin\CustomShippingBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use Elcodi\Bundle\CoreBundle\Interfaces\DependentBundleInterface;
use Elcodi\Component\Plugin\Interfaces\PluginInterface;
use Elcodi\Plugin\CustomShippingBundle\CompilerPass\MappingCompilerPass;
use Elcodi\Plugin\CustomShippingBundle\DependencyInjection\ElcodiCustomShippingExtension;

/**
 * Class ElcodiCustomShippingBundle
 */
class ElcodiCustomShippingBundle extends Bundle implements PluginInterface, DependentBundleInterface
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
        return new ElcodiCustomShippingExtension();
    }

    /**
     * Return all bundle dependencies.
     *
     * Values can be a simple bundle namespace or its instance
     *
     * @return array Bundle instances
     */
    public static function getBundleDependencies()
    {
        return [
            'Elcodi\Bundle\CoreBundle\ElcodiCoreBundle',
            'Elcodi\Bundle\ZoneBundle\ElcodiZoneBundle',
            'Elcodi\Bundle\TaxBundle\ElcodiTaxBundle',
            'Elcodi\Bundle\CurrencyBundle\ElcodiCurrencyBundle',
            'Elcodi\Bundle\EntityTranslatorBundle\ElcodiEntityTranslatorBundle',
            'Elcodi\Bundle\MenuBundle\ElcodiMenuBundle',
        ];
    }
}
