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

namespace Elcodi\Plugin\DelivereaBundle\EventListener;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Currency\Entity\Currency;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Repository\CurrencyRepository;
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Shipping\Entity\ShippingMethod;
use Elcodi\Component\Shipping\Event\ShippingCollectionEvent;
use Elcodi\Plugin\DelivereaBundle\DelivereaShippingMethods;

/**
 * Class ShippingCollectEventListener
 */
class ShippingCollectEventListener
{
    /**
     * @var Plugin
     *
     * The deliverea plugin.
     */
    protected $delivereaPlugin;

    /**
     * @var CurrencyRepository
     *
     * The currency repository.
     */
    protected $currencyRepository;

    /**
     * @var CurrencyConverter
     *
     * The currency converter.
     */
    private $currencyConverter;

    /**
     * Builds a new class.
     *
     * @param Plugin             $delivereaPlugin    The deliverea plugin.
     * @param CurrencyRepository $currencyRepository The currency repository.
     * @param CurrencyConverter  $currencyConverter  The currency converter.
     */
    public function __construct(
        Plugin $delivereaPlugin,
        CurrencyRepository $currencyRepository,
        CurrencyConverter $currencyConverter
    ) {
        $this->delivereaPlugin = $delivereaPlugin;
        $this->currencyRepository = $currencyRepository;
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * Adds the shipping method to the shipping methods list.
     *
     * @param ShippingCollectionEvent $event The shipping collection event.
     */
    public function addCustomShippingMethods(ShippingCollectionEvent $event)
    {
        if (
            $this->delivereaPlugin->isEnabled() &&
            $this->delivereaPlugin->guessIsUsable()
        ) {
            $moneyPrice = $this->getShippingPrice($event->getCart());

            $event
                ->addShippingMethod(new ShippingMethod(
                    DelivereaShippingMethods::DELIVEREA,
                    'asm',
                    'Home delivery',
                    '',
                    $moneyPrice
                ));
        }
    }

    /**
     * Gets the price for the shipping.
     *
     * @param CartInterface $cart
     *
     * @return MoneyInterface
     */
    private function getShippingPrice(CartInterface $cart)
    {
        $cartAmount = $cart->getAmount();

        /** @var CurrencyInterface $euroCurrency */
        $euroCurrency = $this
            ->currencyRepository
            ->findOneBy(['iso' => 'EUR']);

        $cartEuroAmount = $this->currencyConverter->convertMoney(
            $cartAmount,
            $euroCurrency
        );

        $freeFrom = $this->delivereaPlugin->getFieldValue('free_from');
        if (!empty($freeFrom)) {
            $freeFromMoney = Money::create(($freeFrom * 100), $euroCurrency);
            if ($freeFromMoney->isGreaterThan($cartEuroAmount)) {
                $price = (int) $this
                    ->delivereaPlugin
                    ->getFieldValue('shipping_price');

                return Money::create(($price * 100), $euroCurrency);
            } else {
                return Money::create(0, $euroCurrency);
            }
        } else {
            $price = (int) $this
                ->delivereaPlugin
                ->getFieldValue('shipping_price');

            return Money::create(($price * 100), $euroCurrency);
        }
    }
}
