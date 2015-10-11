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

namespace Elcodi\Plugin\StripeBundle\EventListener;

use PaymentSuite\PaymentCoreBundle\Services\Interfaces\PaymentBridgeInterface;
use PaymentSuite\StripeBundle\Router\StripeRoutesLoader;
use PaymentSuite\StripeBundle\Twig\StripeExtension;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Elcodi\Component\Payment\Entity\PaymentMethod;
use Elcodi\Component\Payment\Event\PaymentCollectionEvent;
use Elcodi\Component\Plugin\Entity\Plugin;

/**
 * Class PaymentCollectEventListener
 */
class PaymentCollectEventListener
{
    /**
     * @var UrlGeneratorInterface
     *
     * Router
     */
    protected $router;

    /**
     * @var Plugin
     *
     * Plugin
     */
    protected $plugin;

    /**
     * @var StripeExtension
     *
     * Stripe twig extension.
     */
    protected $stripeTwigExtension;

    /**
     * @var FormFactory
     *
     * Form factory
     */
    protected $formFactory;

    /**
     * @var EngineInterface
     *
     * Templating
     */
    protected $templating;

    /**
     * @var string
     *
     * Public key
     */
    private $publicKey;

    /**
     * @var PaymentBridgeInterface
     *
     * Currency wrapper
     */
    private $paymentBridgeInterface;

    /**
     * Construct
     *
     * @param UrlGeneratorInterface  $router                 Router
     * @param Plugin                 $plugin                 Plugin
     * @param string                 $publicKey              Public key
     * @param FormFactory            $formFactory            Form factory
     * @param PaymentBridgeInterface $paymentBridgeInterface Payment Bridge Interface
     */
    public function __construct(
        UrlGeneratorInterface $router,
        Plugin $plugin,
        $publicKey,
        FormFactory $formFactory,
        PaymentBridgeInterface $paymentBridgeInterface,
        EngineInterface $templating
    ) {
        $this->router = $router;
        $this->plugin = $plugin;
        $this->publicKey = $publicKey;
        $this->formFactory = $formFactory;
        $this->paymentBridgeInterface = $paymentBridgeInterface;
        $this->templating = $templating;
    }

    /**
     * Add Stripe payment method
     *
     * @param PaymentCollectionEvent $event Event
     */
    public function addStripePaymentMethod(PaymentCollectionEvent $event)
    {
        if ($this
            ->plugin
            ->isUsable([
                'private_key',
                'public_key',
            ])
        ) {
            $stripeForm = $this->getStripeForm() . $this->getStripeScript();

            $stripe = new PaymentMethod(
                $this
                    ->plugin
                    ->getHash(),
                'elcodi_plugin.stripe.name',
                'elcodi_plugin.stripe.description',
                '',
                '',
                $stripeForm
            );

            $event->addPaymentMethod($stripe);
        }
    }

    /**
     * Return stripe form
     *
     * @return string Stripe form
     */
    protected function getStripeForm()
    {
        $formType = $this
            ->formFactory
            ->create('stripe_view');

        return $this
            ->templating
            ->render('StripeBundle:Stripe:view.html.twig', [
                'stripe_form'  =>  $formType->createView(),
                'stripe_execute_route' =>  StripeRoutesLoader::ROUTE_NAME,
            ]);
    }

    /**
     * Return stripe script
     *
     * @return string Stripe script
     */
    protected function getStripeScript()
    {
        $currency = $this
            ->paymentBridgeInterface
            ->getCurrency();

        return $this
            ->templating
            ->render('StripeBundle:Stripe:scripts.html.twig', [
                'public_key'    =>  $this->publicKey,
                'currency'      =>  $currency,
            ]);
    }
}
