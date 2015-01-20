<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Class AppKernel
 */
class AppKernel extends Kernel
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

            new \Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new \Mmoreram\ControllerExtraBundle\ControllerExtraBundle(),
            new \Ornicar\GravatarBundle\OrnicarGravatarBundle(),
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

            /**
             * Elcodi store bundle
             */
            new \Elcodi\Store\StoreCoreBundle\StoreCoreBundle(),
            new \Elcodi\Store\StoreProductBundle\StoreProductBundle(),
            new \Elcodi\Store\StoreUserBundle\StoreUserBundle(),
            new \Elcodi\Store\StoreGeoBundle\StoreGeoBundle(),
            new \Elcodi\Store\StoreCartBundle\StoreCartBundle(),
            new \Elcodi\Store\StoreCurrencyBundle\StoreCurrencyBundle,
            new \Elcodi\Store\StoreCartCouponBundle\StoreCartCouponBundle,
            new \Elcodi\Store\StoreConnectBundle\StoreConnectBundle(),
            new \Elcodi\Store\PaymentBridgeBundle\PaymentBridgeBundle(),

            /**
             * Elcodi admin bundles
             */
            new \Elcodi\Admin\AdminCoreBundle\AdminCoreBundle(),
            new \Elcodi\Admin\AdminUserBundle\AdminUserBundle(),
            new \Elcodi\Admin\AdminAttributeBundle\AdminAttributeBundle(),
            new \Elcodi\Admin\AdminBannerBundle\AdminBannerBundle(),
            new \Elcodi\Admin\AdminCartBundle\AdminCartBundle(),
            new \Elcodi\Admin\AdminCartCouponBundle\AdminCartCouponBundle(),
            new \Elcodi\Admin\AdminCouponBundle\AdminCouponBundle(),
            new \Elcodi\Admin\AdminCurrencyBundle\AdminCurrencyBundle(),
            new \Elcodi\Admin\AdminLanguageBundle\AdminLanguageBundle(),
            new \Elcodi\Admin\AdminMediaBundle\AdminMediaBundle(),
            new \Elcodi\Admin\AdminNewsletterBundle\AdminNewsletterBundle(),
            new \Elcodi\Admin\AdminProductBundle\AdminProductBundle(),
            new \Elcodi\Admin\AdminRuleBundle\AdminRuleBundle(),
            new \Elcodi\Admin\AdminConfigurationBundle\AdminConfigurationBundle(),
            new \Elcodi\Admin\AdminPageBundle\AdminPageBundle(),
            new \Elcodi\Admin\AdminTemplateBundle\AdminTemplateBundle(),

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
