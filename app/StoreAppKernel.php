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
            new \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new \Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new \JMS\SerializerBundle\JMSSerializerBundle(),
            new \JMS\AopBundle\JMSAopBundle(),
            new \JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new \Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new \Mmoreram\ControllerExtraBundle\ControllerExtraBundle(),
            new \PaymentSuite\PaymentCoreBundle\PaymentCoreBundle(),
            new \PaymentSuite\FreePaymentBundle\FreePaymentBundle(),
            new \PaymentSuite\PaypalWebCheckoutBundle\PaypalWebCheckoutBundle(),
            new \HWI\Bundle\OAuthBundle\HWIOAuthBundle(),

            /**
             * Elcodi core bundles
             */
            new \Elcodi\Bundle\BambooBundle\ElcodiBambooBundle(),
            new \Elcodi\Bundle\CoreBundle\ElcodiCoreBundle(),
            new \Elcodi\Bundle\LanguageBundle\ElcodiLanguageBundle(),
            new \Elcodi\Bundle\CartBundle\ElcodiCartBundle(),
            new \Elcodi\Bundle\CartCouponBundle\ElcodiCartCouponBundle(),
            new \Elcodi\Bundle\CouponBundle\ElcodiCouponBundle(),
            new \Elcodi\Bundle\BannerBundle\ElcodiBannerBundle(),
            new \Elcodi\Bundle\CurrencyBundle\ElcodiCurrencyBundle(),
            new \Elcodi\Bundle\UserBundle\ElcodiUserBundle(),
            new \Elcodi\Bundle\AttributeBundle\ElcodiAttributeBundle(),
            new \Elcodi\Bundle\ProductBundle\ElcodiProductBundle(),
            new \Elcodi\Bundle\MediaBundle\ElcodiMediaBundle(),
            new \Elcodi\Bundle\GeoBundle\ElcodiGeoBundle(),
            new \Elcodi\Bundle\RuleBundle\ElcodiRuleBundle(),
            new \Elcodi\Bundle\MenuBundle\ElcodiMenuBundle(),
            new \Elcodi\Bundle\TaxBundle\ElcodiTaxBundle(),
            new \Elcodi\Bundle\EntityTranslatorBundle\ElcodiEntityTranslatorBundle(),
            new \Elcodi\Bundle\StateTransitionMachineBundle\ElcodiStateTransitionMachineBundle(),
            new \Elcodi\Bundle\ConfigurationBundle\ElcodiConfigurationBundle(),
            new \Elcodi\Bundle\PageBundle\ElcodiPageBundle(),

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
            new \Elcodi\StoreConnectBundle\StoreConnectBundle(),
            new \Elcodi\PaymentBridgeBundle\PaymentBridgeBundle(),

            /**
             * Elcodi Templates
             */
            new \Elcodi\StoreTemplateBundle\StoreTemplateBundle(),
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
