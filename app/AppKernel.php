<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

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
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new \Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new \JMS\SerializerBundle\JMSSerializerBundle(),
            new \JMS\AopBundle\JMSAopBundle(),
            new \JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new \Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new \Mmoreram\ControllerExtraBundle\ControllerExtraBundle(),
            new \Ornicar\GravatarBundle\OrnicarGravatarBundle(),

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
            new \Elcodi\GeoBundle\ElcodiGeoBundle(),
            new \Elcodi\ProductBundle\ElcodiProductBundle(),
            new \Elcodi\MediaBundle\ElcodiMediaBundle(),
            new \Elcodi\MenuBundle\ElcodiMenuBundle(),
            new \Elcodi\RuleBundle\ElcodiRuleBundle(),
            new \Elcodi\NewsletterBundle\ElcodiNewsletterBundle(),

            /**
             * Elcodi store bundles
             */
            new \Admin\AdminCoreBundle\AdminCoreBundle(),
            new \Admin\AdminMenuBundle\AdminMenuBundle(),
            new \Admin\AdminUserBundle\AdminUserBundle(),
            new \Admin\AdminBannerBundle\AdminBannerBundle(),
            new \Admin\AdminCartBundle\AdminCartBundle(),
            new \Admin\AdminCartCouponBundle\AdminCartCouponBundle(),
            new \Admin\AdminCouponBundle\AdminCouponBundle(),
            new \Admin\AdminCurrencyBundle\AdminCurrencyBundle(),
            new \Admin\AdminMediaBundle\AdminMediaBundle(),
            new \Admin\AdminNewsletterBundle\AdminNewsletterBundle(),
            new \Admin\AdminProductBundle\AdminProductBundle(),
            new \Admin\AdminRuleBundle\AdminRuleBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
