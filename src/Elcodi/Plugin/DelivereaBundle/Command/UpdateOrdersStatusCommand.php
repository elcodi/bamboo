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

namespace Elcodi\Plugin\DelivereaBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Plugin\DelivereaBundle\Entity\DelivereaShipment;
use Elcodi\Plugin\DelivereaBundle\Repository\DelivereaShipmentRepository;
use Elcodi\Plugin\DelivereaBundle\Services\OrderStateUpdater;

/**
 * Class UpdateOrdersStatusCommand
 */
class UpdateOrdersStatusCommand extends Command
{
    /**
     * @var DelivereaShipmentRepository
     *
     * The delivery shipment repository
     */
    private $delivereaShipmentRepository;

    /**
     * @var OrderStateUpdater
     *
     * The order state updater
     */
    private $orderStateUpdater;

    /**
     * Builds a new class.
     *
     * @param DelivereaShipmentRepository $delivereaShipmentRepository The deliverea shipment repository.
     * @param OrderStateUpdater           $orderStateUpdater           The order state updater.
     */
    public function __construct(
        DelivereaShipmentRepository $delivereaShipmentRepository,
        OrderStateUpdater $orderStateUpdater
    ) {
        parent::__construct();

        $this->delivereaShipmentRepository = $delivereaShipmentRepository;
        $this->orderStateUpdater = $orderStateUpdater;
    }

    /**
     * Configures the command
     */
    protected function configure()
    {
        $this
            ->setName('deliverea:orders:update')
            ->setDescription('Updates the status for all the orders');
    }

    /**
     * This command udpates the status for all the orders
     *
     * @param InputInterface  $input  The input interface
     * @param OutputInterface $output The output interface
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->writeMessage('Started updating orders', $output);

        $this->writeMessage('Getting shipments to check for update', $output);
        $shipmentsPending = $this->getShipmentsWithActionsPending();

        foreach ($shipmentsPending as $shipment) {
            /**
             * @var DelivereaShipment $shipment
             */
            $message = sprintf(
                'Updating Deliverea shipment: %s',
                $shipment->getDelivereaShippingRef()
            );
            $this->writeMessage($message, $output);

            $this->updateShipment($shipment);

            $this->writeMessage('Shipment updated', $output);
        }

        $this->writeMessage('Update process finished', $output);
    }

    /**
     * Gets the shipments with pending actions.
     *
     * @return array(ShippingMethod)
     */
    private function getShipmentsWithActionsPending()
    {
        return $this
            ->delivereaShipmentRepository
            ->getShipmentsWithActionsPending();
    }

    /**
     * Updates the shipment and the order if the shipment has changed.
     *
     * @param DelivereaShipment $shipment The shipment to update
     */
    private function updateShipment(DelivereaShipment $shipment)
    {
        $this->orderStateUpdater->updateState($shipment);
    }

    /**
     * Writes a message into the screen.
     *
     * @param string          $message The message to print.
     * @param OutputInterface $output  The output.
     */
    private function writeMessage($message, OutputInterface $output)
    {
        $formatter = $this->getHelper('formatter');
        $formattedLine = $formatter->formatSection(
            'Deliverea',
            $message
        );
        $output->writeln($formattedLine);
    }
}
