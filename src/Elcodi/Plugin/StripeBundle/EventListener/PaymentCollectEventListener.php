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

namespace Elcodi\Plugin\StripeBundle\EventListener;

use PaymentSuite\PaymentCoreBundle\Services\Interfaces\PaymentBridgeInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Templating\EngineInterface;

use Elcodi\Component\Payment\Entity\PaymentMethod;
use Elcodi\Component\Payment\Event\PaymentCollectionEvent;
use Elcodi\Component\Plugin\Entity\Plugin;

/**
 * Class PaymentCollectEventListener
 */
class PaymentCollectEventListener
{
    /**
     * @var Plugin
     *
     * Plugin
     */
    private $plugin;

    /**
     * @var FormFactory
     *
     * Form factory
     */
    private $formFactory;

    /**
     * @var EngineInterface
     *
     * Templating
     */
    private $templating;

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
     * @param Plugin                 $plugin                 Plugin
     * @param PaymentBridgeInterface $paymentBridgeInterface Payment Bridge Interface
     * @param FormFactory            $formFactory            Form factory
     * @param EngineInterface        $templating             Templating
     * @param string                 $publicKey              Public key
     */
    public function __construct(
        Plugin $plugin,
        PaymentBridgeInterface $paymentBridgeInterface,
        FormFactory $formFactory,
        EngineInterface $templating,
        $publicKey
    ) {
        $this->plugin = $plugin;
        $this->paymentBridgeInterface = $paymentBridgeInterface;
        $this->formFactory = $formFactory;
        $this->templating = $templating;
        $this->publicKey = $publicKey;
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
                'stripe_form'          => $formType->createView(),
                'stripe_execute_route' => 'paymentsuite_stripe_execute',
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
                'public_key' => $this->publicKey,
                'currency'   => $currency,
            ]);
    }
}
