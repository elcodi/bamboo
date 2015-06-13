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
use Elcodi\Plugin\DelivereaBundle\Repository\DelivereaShipmentRepository;
use Elcodi\Plugin\DelivereaBundle\Services\ShippingMethodChecker;

/**
 * Class PrintLabelButton
 */
class PrintLabelButton
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
    private $router;

    /**
     * Builds a new class.
     *
     * @param ShippingMethodChecker       $shippingMethodChecker       The shipping method checker.
     * @param DelivereaShipmentRepository $delivereaShipmentRepository The deliverea shipment repository.
     * @param UrlGeneratorInterface       $router                      An url generator.
     */
    public function __construct(
        ShippingMethodChecker $shippingMethodChecker,
        DelivereaShipmentRepository $delivereaShipmentRepository,
        UrlGeneratorInterface $router
    ) {
        $this->shippingMethodChecker = $shippingMethodChecker;
        $this->delivereaShipmentRepository = $delivereaShipmentRepository;
        $this->router = $router;
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
    public function renderLabelButton(EventInterface $event)
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
                    $delivereaShippingRef = $delivereaShipment
                        ->getDelivereaShippingRef();

                    $labelUrl = $this
                        ->router
                        ->generate(
                            'deliverea_view_label',
                            ['delivereaRef' => $delivereaShippingRef]
                        );

                    $this->appendTemplate(
                        '@ElcodiDeliverea/Admin/print-button.html.twig',
                        $event,
                        $this->plugin,
                        ['labelUrl' => $labelUrl]
                    );
                }
            }
        }
    }
}
