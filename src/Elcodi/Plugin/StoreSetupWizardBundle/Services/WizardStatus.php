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

namespace Elcodi\Plugin\StoreSetupWizardBundle\Services;

use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Repository\ProductRepository;
use Elcodi\Component\Store\Entity\Interfaces\StoreInterface;

/**
 * Class WizardStatus
 */
class WizardStatus
{
    /**
     * @var ProductRepository
     *
     * Product repository
     */
    protected $productRepository;

    /**
     * @var StoreInterface
     *
     * Store
     */
    protected $store;

    /**
     * @var Plugin[]
     *
     * The payment enabled Plugins
     */
    private $enabledPaymentPlugins;

    /**
     * @var Plugin[]
     *
     * The shipping enabled Plugins
     */
    private $enabledShippingPlugins;

    /**
     * Builds a new WizardStepChecker
     *
     * @param ProductRepository $productRepository      Product repository
     * @param StoreInterface    $store                  Store
     * @param array             $enabledPaymentPlugins  The enabled payment methods
     * @param array             $enabledShippingPlugins The enabled shipping methods
     */
    public function __construct(
        ProductRepository $productRepository,
        StoreInterface $store,
        array $enabledPaymentPlugins,
        array $enabledShippingPlugins
    ) {
        $this->productRepository = $productRepository;
        $this->store = $store;
        $this->enabledPaymentPlugins = $enabledPaymentPlugins;
        $this->enabledShippingPlugins = $enabledShippingPlugins;
    }

    /**
     * Checks if the wizard has already been finished
     *
     * @return boolean
     */
    public function isWizardFinished()
    {
        return is_null($this->getNextStep());
    }

    /**
     * Get the next step.
     *
     * @return integer|null The next step, null if the wizard is finished.
     */
    public function getNextStep()
    {
        $stepsFinishedStatus = $this->getStepsFinishStatus();

        foreach ($stepsFinishedStatus as $step => $stepIsFinished) {
            if (!$stepIsFinished) {
                return (int) $step;
            }
        }

        return null;
    }

    /**
     * Checks if the received step is finished.
     *
     * @param integer $stepNumber A step number.
     *
     * @return boolean If the step is finished
     */
    public function isStepFinished($stepNumber)
    {
        switch ($stepNumber) {
            case 1:
                return $this->isThereAnyProduct();
            case 2:
                return $this->isAddressFulfilled();
            case 3:
                return $this->isPaymentFulfilled();
            case 4:
                return $this->isShippingFulfilled();
            default:
                return true;
        }
    }

    /**
     * Gets the finish status for all the steps
     *
     * @return boolean[]
     */
    public function getStepsFinishStatus()
    {
        return [
            1 => $this->isStepFinished(1),
            2 => $this->isStepFinished(2),
            3 => $this->isStepFinished(3),
            4 => $this->isStepFinished(4),
        ];
    }

    /**
     * Checks if the address has been fulfilled.
     *
     * @return boolean
     */
    protected function isAddressFulfilled()
    {
        $storeAddress = $this
            ->store
            ->getAddress();

        return
            $storeAddress instanceof AddressInterface &&
            $storeAddress->getCity() != '' &&
            $storeAddress->getCity() != null &&
            $storeAddress->getAddress() != '' &&
            $storeAddress->getPostalcode() != '';
    }

    /**
     * Checks if there is any product on the store.
     *
     * @return boolean
     */
    protected function isThereAnyProduct()
    {
        $enabledProduct = $this
            ->productRepository
            ->findOneBy([
                'enabled' => true,
            ]);

        return ($enabledProduct instanceof ProductInterface);
    }

    /**
     * Checks if the payment has been fulfilled
     *
     * @return boolean
     */
    protected function isPaymentFulfilled()
    {
        return array_reduce(
            $this->enabledPaymentPlugins,
            function ($value, Plugin $plugin) {

                return $value || $plugin->guessIsUsable();
            },
            false
        );
    }

    /**
     * Checks if any shipping range has been added to the store.
     *
     * @return boolean
     */
    protected function isShippingFulfilled()
    {
        return array_reduce(
            $this->enabledShippingPlugins,
            function ($value, Plugin $plugin) {

                return $value || $plugin->guessIsUsable();
            },
            false
        );
    }
}
