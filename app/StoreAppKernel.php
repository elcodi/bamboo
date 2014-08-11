<?php

/**
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

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Class StoreAppKernel
 */
class StoreAppKernel extends Kernel
{
    /**
     * Register common bundles in all environments
     */
    public function registerBundles()
    {
        $bundles = array(

            /**
             * Symfony dependencies
             */
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
            new \Symfony\Bundle\MonologBundle\MonologBundle(),
            new \Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new \Symfony\Bundle\AsseticBundle\AsseticBundle(),

            /**
             * Third-party dependencies
             */
            new \Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle(),
            new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new \Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new \JMS\SerializerBundle\JMSSerializerBundle(),
            new \JMS\AopBundle\JMSAopBundle(),
            new \JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new \Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new \Mmoreram\ControllerExtraBundle\ControllerExtraBundle(),
            new \PaymentSuite\PaymentCoreBundle\PaymentCoreBundle(),
            new \PaymentSuite\FreePaymentBundle\FreePaymentBundle(),

            /**
             * Elcodi core bundles
             */
            new \Elcodi\CoreBundle\ElcodiCoreBundle(),
            new \Elcodi\LanguageBundle\ElcodiLanguageBundle(),
            new \Elcodi\CartBundle\ElcodiCartBundle(),
            new \Elcodi\CartCouponBundle\ElcodiCartCouponBundle(),
            new \Elcodi\CouponBundle\ElcodiCouponBundle(),
            new \Elcodi\BannerBundle\ElcodiBannerBundle(),
            new \Elcodi\CurrencyBundle\ElcodiCurrencyBundle(),
            new \Elcodi\UserBundle\ElcodiUserBundle(),
            new \Elcodi\AttributeBundle\ElcodiAttributeBundle(),
            new \Elcodi\ProductBundle\ElcodiProductBundle(),
            new \Elcodi\MediaBundle\ElcodiMediaBundle(),
            new \Elcodi\GeoBundle\ElcodiGeoBundle(),
            new \Elcodi\RuleBundle\ElcodiRuleBundle(),

            /**
             * Elcodi store bundles
             */
            new \Elcodi\StoreCoreBundle\StoreCoreBundle(),
            new \Elcodi\StoreProductBundle\StoreProductBundle(),
            new \Elcodi\StoreUserBundle\StoreUserBundle(),
            new \Elcodi\StoreGeoBundle\StoreGeoBundle(),
            new \Elcodi\StoreCartBundle\StoreCartBundle(),
            new \Elcodi\StoreCurrencyBundle\StoreCurrencyBundle,
            new \Elcodi\StoreCartCouponBundle\StoreCartCouponBundle,
            new \Elcodi\PaymentBridgeBundle\PaymentBridgeBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
        }

        return $bundles;
    }

    /**
     * Register container configuration
     *
     * @param LoaderInterface $loader Loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
