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

namespace Elcodi\Plugin\DelivereaBundle\Templating;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\EventDispatcher\Interfaces\EventInterface;
use Elcodi\Component\Plugin\Templating\Traits\TemplatingTrait;
use Elcodi\Plugin\DelivereaBundle\Entity\DelivereaShipment;
use Elcodi\Plugin\DelivereaBundle\Manager\Tracking as TrackingManager;
use Elcodi\Plugin\DelivereaBundle\Repository\DelivereaShipmentRepository;
use Elcodi\Plugin\DelivereaBundle\Services\ShippingMethodChecker;

/**
 * Class AdminOrderCarrierInfo
 */
class AdminOrderCarrierInfo
{
    use TemplatingTrait;

    /**
     * @var Plugin
     *
     * Plugin
     */
    private $plugin;

    /**
     * @var ShippingMethodChecker
     *
     * The shipping method checker.
     */
    private $shippingMethodChecker;

    /**
     * @var DelivereaShipmentRepository
     *
     * The deliverea shipment repository.
     */
    private $delivereaShipmentRepository;

    /**
     * @var UrlGeneratorInterface
     *
     * An url generator.
     */
    private $urlGenerator;

    /**
     * @var TrackingManager
     *
     * The tracking manager to get tracking info.
     */
    private $tracking;

    /**
     * Builds a new class
     *
     * @param ShippingMethodChecker       $shippingMethodChecker       The shipping method checker.
     * @param DelivereaShipmentRepository $delivereaShipmentRepository The deliverea shipment repository.
     * @param UrlGeneratorInterface       $urlGenerator                An url generator.
     * @param TrackingManager             $tracking                    The tracking manager.
     */
    public function __construct(
        ShippingMethodChecker $shippingMethodChecker,
        DelivereaShipmentRepository $delivereaShipmentRepository,
        UrlGeneratorInterface $urlGenerator,
        TrackingManager $tracking
    ) {
        $this->shippingMethodChecker = $shippingMethodChecker;
        $this->delivereaShipmentRepository = $delivereaShipmentRepository;
        $this->urlGenerator = $urlGenerator;
        $this->tracking = $tracking;
    }

    /**
     * Set the plugin
     *
     * @param Plugin $plugin Plugin
     *
     * @return $this Self object
     */
    public function setPlugin(Plugin $plugin)
    {
        $this->plugin = $plugin;

        return $this;
    }

    /**
     * Renders the print label button.
     *
     * @param EventInterface $event The event
     */
    public function renderOrderInfo(EventInterface $event)
    {
        if (
            $this->plugin->guessIsUsable() &&
            $this->plugin->isEnabled()
        ) {
            $context = $event->getContext();
            $order = $context['order'];

            if (
                $order instanceof OrderInterface &&
                $this->shippingMethodChecker->orderHasDelivereaShipping($order)
            ) {

                /** @var DelivereaShipment $delivereaShipment */
                $delivereaShipment = $this
                    ->delivereaShipmentRepository
                    ->getDelivereaShipment($order);

                if (!is_null($delivereaShipment)) {
                    $delivereaShippingRef =
                        $delivereaShipment->getDelivereaShippingRef();

                    $trackingInfo = $this
                        ->tracking
                        ->getTracking($delivereaShippingRef);

                    $this->appendTemplate(
                        '@ElcodiDeliverea/Admin/order-tracking.html.twig',
                        $event,
                        $this->plugin,
                        ['trackingInfo' => $trackingInfo]
                    );
                } else {
                    $this->appendTemplate(
                        '@ElcodiDeliverea/Admin/order-pending.html.twig',
                        $event,
                        $this->plugin
                    );
                }
            }
        }
    }
}
