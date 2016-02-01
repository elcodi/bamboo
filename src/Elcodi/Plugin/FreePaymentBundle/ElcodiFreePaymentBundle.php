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

namespace Elcodi\Plugin\FreePaymentBundle;

use Mmoreram\SymfonyBundleDependencies\DependentBundleInterface;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use Elcodi\Bundle\CoreBundle\Abstracts\AbstractElcodiBundle;
use Elcodi\Component\Plugin\Interfaces\PluginInterface;
use Elcodi\Plugin\FreePaymentBundle\DependencyInjection\ElcodiFreePaymentExtension;

/**
 * Class ElcodiFreePaymentBundle
 */
class ElcodiFreePaymentBundle
    extends AbstractElcodiBundle
    implements PluginInterface, DependentBundleInterface
{
    /**
     * Returns the bundle's container extension.
     *
     * @return ExtensionInterface The container extension
     */
    public function getContainerExtension()
    {
        return new ElcodiFreePaymentExtension();
    }

    /**
     * Create instance of current bundle, and return dependent bundle namespaces
     *
     * @return array Bundle instances
     */
    public static function getBundleDependencies(KernelInterface $kernel)
    {
        return [
            'Elcodi\Bridge\PaymentSuiteBridgeBundle\ElcodiPaymentSuiteBridgeBundle',
            'PaymentSuite\FreePaymentBundle\FreePaymentBundle',
        ];
    }
}
