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
 * @author Elcodi Team <tech@elcodi.com>
 */

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Elcodi\Bundle\CoreBundle\Traits\BundleDependenciesResolver;

/**
 * Class AppKernel
 */
class AppKernel extends Kernel
{
    use BundleDependenciesResolver;

    /**
     * Returns an array of bundles to register.
     *
     * @return BundleInterface[] An array of bundle instances.
     *
     * @api
     */
    public function registerBundles()
    {
        $bundles = array(

            /**
             * Symfony dependencies
             */
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),

            /**
             * Third-party dependencies
             */
            new Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new Ornicar\GravatarBundle\OrnicarGravatarBundle(),
            new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),
            new Snc\RedisBundle\SncRedisBundle(),
            new JMS\I18nRoutingBundle\JMSI18nRoutingBundle(),
            new JMS\TranslationBundle\JMSTranslationBundle(),
            new Mmoreram\ControllerExtraBundle\ControllerExtraBundle(),
            new Mmoreram\CacheFlushBundle\CacheFlushBundle(),
            new Mmoreram\HttpHeadersBundle\HttpHeadersBundle(),

            /**
             * Elcodi core bundles
             */
            new Elcodi\Bundle\CoreBundle\ElcodiCoreBundle(),
            new Elcodi\Bundle\LanguageBundle\ElcodiLanguageBundle(),
            new Elcodi\Bundle\CartBundle\ElcodiCartBundle(),
            new Elcodi\Bundle\CartCouponBundle\ElcodiCartCouponBundle(),
            new Elcodi\Bundle\CouponBundle\ElcodiCouponBundle(),
            new Elcodi\Bundle\BannerBundle\ElcodiBannerBundle(),
            new Elcodi\Bundle\CurrencyBundle\ElcodiCurrencyBundle(),
            new Elcodi\Bundle\UserBundle\ElcodiUserBundle(),
            new Elcodi\Bundle\GeoBundle\ElcodiGeoBundle(),
            new Elcodi\Bundle\ProductBundle\ElcodiProductBundle(),
            new Elcodi\Bundle\AttributeBundle\ElcodiAttributeBundle(),
            new Elcodi\Bundle\MediaBundle\ElcodiMediaBundle(),
            new Elcodi\Bundle\RuleBundle\ElcodiRuleBundle(),
            new Elcodi\Bundle\NewsletterBundle\ElcodiNewsletterBundle(),
            new Elcodi\Bundle\MenuBundle\ElcodiMenuBundle(),
            new Elcodi\Bundle\TaxBundle\ElcodiTaxBundle(),
            new Elcodi\Bundle\EntityTranslatorBundle\ElcodiEntityTranslatorBundle(),
            new Elcodi\Bundle\StateTransitionMachineBundle\ElcodiStateTransitionMachineBundle(),
            new Elcodi\Bundle\PageBundle\ElcodiPageBundle(),
            new Elcodi\Bundle\MetricBundle\ElcodiMetricBundle(),
            new Elcodi\Bundle\PluginBundle\ElcodiPluginBundle($this),
            new Elcodi\Bundle\CommentBundle\ElcodiCommentBundle(),
            new Elcodi\Bundle\ZoneBundle\ElcodiZoneBundle(),
            new Elcodi\Bundle\ShippingBundle\ElcodiShippingBundle(),
            new Elcodi\Bundle\SitemapBundle\ElcodiSitemapBundle(),
            new Elcodi\Bundle\PaymentBundle\ElcodiPaymentBundle(),
            new Elcodi\Bundle\StoreBundle\ElcodiStoreBundle(),

            /**
             * Elcodi store bundle
             */
            new Elcodi\Store\CoreBundle\StoreCoreBundle(),
            new Elcodi\Store\ProductBundle\StoreProductBundle(),
            new Elcodi\Store\UserBundle\StoreUserBundle(),
            new Elcodi\Store\GeoBundle\StoreGeoBundle(),
            new Elcodi\Store\CartBundle\StoreCartBundle(),
            new Elcodi\Store\CurrencyBundle\StoreCurrencyBundle(),
            new Elcodi\Store\CartCouponBundle\StoreCartCouponBundle(),
            new Elcodi\Store\ConnectBundle\StoreConnectBundle(),
            new Elcodi\Store\MetricBundle\StoreMetricBundle(),
            new Elcodi\Store\PageBundle\StorePageBundle(),
            new Elcodi\Store\LanguageBundle\StoreLanguageBundle(),
            new Elcodi\Store\OverrideBundle\StoreOverrideBundle(),
            new Elcodi\Store\FallbackBundle\StoreFallbackBundle(),

            /**
             * Elcodi admin bundles
             */
            new Elcodi\Admin\CoreBundle\AdminCoreBundle(),
            new Elcodi\Admin\UserBundle\AdminUserBundle(),
            new Elcodi\Admin\AttributeBundle\AdminAttributeBundle(),
            new Elcodi\Admin\BannerBundle\AdminBannerBundle(),
            new Elcodi\Admin\CartBundle\AdminCartBundle(),
            new Elcodi\Admin\CouponBundle\AdminCouponBundle(),
            new Elcodi\Admin\CurrencyBundle\AdminCurrencyBundle(),
            new Elcodi\Admin\LanguageBundle\AdminLanguageBundle(),
            new Elcodi\Admin\MediaBundle\AdminMediaBundle(),
            new Elcodi\Admin\NewsletterBundle\AdminNewsletterBundle(),
            new Elcodi\Admin\ProductBundle\AdminProductBundle(),
            new Elcodi\Admin\PageBundle\AdminPageBundle(),
            new Elcodi\Admin\TemplateBundle\AdminTemplateBundle(),
            new Elcodi\Admin\MetricBundle\AdminMetricBundle(),
            new Elcodi\Admin\PluginBundle\AdminPluginBundle(),
            new Elcodi\Admin\ShippingBundle\AdminShippingBundle(),
            new Elcodi\Admin\GeoBundle\AdminGeoBundle(),
            new Elcodi\Admin\PaymentBundle\AdminPaymentBundle(),
            new Elcodi\Admin\StoreBundle\AdminStoreBundle(),

            /**
             * Elcodi common bundle
             */
            new Elcodi\Common\FirewallBundle\ElcodiFirewallBundle(),
            new Elcodi\Common\CommonBundle\ElcodiCommonBundle(),

            /**
             * Elcodi Plugins
             */
            new Elcodi\Plugin\GoogleAnalyticsBundle\ElcodiGoogleAnalyticsBundle(),
            new Elcodi\Plugin\PinterestBundle\ElcodiPinterestBundle(),
            new Elcodi\Plugin\ProductCsvBundle\ElcodiProductCsvBundle(),
            new Elcodi\Plugin\StoreSetupWizardBundle\ElcodiStoreSetupWizardBundle(),
            new Elcodi\Plugin\DisqusBundle\ElcodiDisqusBundle(),
            new Elcodi\Plugin\TwitterBundle\ElcodiTwitterBundle(),
            new Elcodi\Plugin\FacebookBundle\ElcodiFacebookBundle(),
            new Elcodi\Plugin\StoreTemplateBundle\StoreTemplateBundle(),
            new Elcodi\Plugin\PaypalWebCheckoutBundle\ElcodiPaypalWebCheckoutBundle(),
            new Elcodi\Plugin\FreePaymentBundle\ElcodiFreePaymentBundle(),
            new Elcodi\Plugin\StripeBundle\ElcodiStripeBundle(),
            new Elcodi\Plugin\CustomShippingBundle\ElcodiCustomShippingBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {

            $bundles[] = new Elcodi\Bundle\FixturesBoosterBundle\ElcodiFixturesBoosterBundle();
            $bundles[] = new Elcodi\Bridge\BehatBridgeBundle\BehatBridgeBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
        }

        if (class_exists('Visithor\Bundle\VisithorBundle')) {
            $bundles[] = new Visithor\Bundle\VisithorBundle();
            $bundles[] = new Elcodi\Bridge\VisithorBridgeBundle\ElcodiVisithorBridgeBundle();
        }

        return $this
            ->getBundleInstances(
                $this,
                $bundles
            );
    }

    /**
     * Loads the container configuration.
     *
     * @param LoaderInterface $loader A LoaderInterface instance
     *
     * @api
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
