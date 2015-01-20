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
 * Class AdminAppKernel
 */
class AdminAppKernel extends Kernel
{
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
            new \Ornicar\GravatarBundle\OrnicarGravatarBundle(),
            new Snc\RedisBundle\SncRedisBundle(),

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
            new \Elcodi\Bundle\GeoBundle\ElcodiGeoBundle(),
            new \Elcodi\Bundle\ProductBundle\ElcodiProductBundle(),
            new \Elcodi\Bundle\AttributeBundle\ElcodiAttributeBundle(),
            new \Elcodi\Bundle\MediaBundle\ElcodiMediaBundle(),
            new \Elcodi\Bundle\RuleBundle\ElcodiRuleBundle(),
            new \Elcodi\Bundle\NewsletterBundle\ElcodiNewsletterBundle(),
            new \Elcodi\Bundle\MenuBundle\ElcodiMenuBundle(),
            new \Elcodi\Bundle\TaxBundle\ElcodiTaxBundle(),
            new \Elcodi\Bundle\EntityTranslatorBundle\ElcodiEntityTranslatorBundle(),
            new \Elcodi\Bundle\StateTransitionMachineBundle\ElcodiStateTransitionMachineBundle(),
            new \Elcodi\Bundle\ConfigurationBundle\ElcodiConfigurationBundle(),
            new \Elcodi\Bundle\PageBundle\ElcodiPageBundle(),
            new \Elcodi\Bundle\SitemapBundle\ElcodiSitemapBundle(),
            new \Elcodi\Bundle\MetricBundle\ElcodiMetricBundle(),

            /**
             * Elcodi admin bundles
             */
            new \Elcodi\AdminCoreBundle\AdminCoreBundle(),
            new \Elcodi\AdminUserBundle\AdminUserBundle(),
            new \Elcodi\AdminAttributeBundle\AdminAttributeBundle(),
            new \Elcodi\AdminBannerBundle\AdminBannerBundle(),
            new \Elcodi\AdminCartBundle\AdminCartBundle(),
            new \Elcodi\AdminCartCouponBundle\AdminCartCouponBundle(),
            new \Elcodi\AdminCouponBundle\AdminCouponBundle(),
            new \Elcodi\AdminCurrencyBundle\AdminCurrencyBundle(),
            new \Elcodi\AdminLanguageBundle\AdminLanguageBundle(),
            new \Elcodi\AdminMediaBundle\AdminMediaBundle(),
            new \Elcodi\AdminNewsletterBundle\AdminNewsletterBundle(),
            new \Elcodi\AdminProductBundle\AdminProductBundle(),
            new \Elcodi\AdminRuleBundle\AdminRuleBundle(),
            new \Elcodi\AdminConfigurationBundle\AdminConfigurationBundle(),
            new \Elcodi\AdminPageBundle\AdminPageBundle(),
            new \Elcodi\AdminTemplateBundle\AdminTemplateBundle(),
            new \Elcodi\AdminMetricBundle\AdminMetricBundle(),

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

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
