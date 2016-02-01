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

namespace Elcodi\Plugin\BankwireBundle\EventListener;

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
     * Construct
     *
     * @param UrlGeneratorInterface $router Router
     * @param Plugin                $plugin Plugin
     */
    public function __construct(
        UrlGeneratorInterface $router,
        Plugin $plugin
    ) {
        $this->router = $router;
        $this->plugin = $plugin;
    }

    /**
     * Add Free payment method
     *
     * @param PaymentCollectionEvent $event Event
     */
    public function addFreePaymentPaymentMethod(PaymentCollectionEvent $event)
    {
        if ($this
            ->plugin
            ->isUsable()
        ) {
            $bankwire = new PaymentMethod(
                $this
                    ->plugin
                    ->getHash(),
                'elcodi_plugin.bankwire.name',
                'elcodi_plugin.bankwire.description',
                $this
                    ->router
                    ->generate('paymentsuite_bankwire_execute')
            );

            $event->addPaymentMethod($bankwire);
        }
    }
}
