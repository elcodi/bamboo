<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\AdminCartBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;

/**
 * Class CartData
 */
class CartData extends AbstractFixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * Carts
         *
         * @var CartInterface     $emptyCart
         * @var CartInterface     $fullCart
         * @var CurrencyInterface $currency
         * @var CustomerInterface $customer
         * @var ProductInterface  $product
         * @var ProductInterface  $productReduced
         * @var CartLineInterface $cartLine1
         * @var CartLineInterface $cartLine2
         */
        $emptyCart = $this->container->get('elcodi.core.cart.factory.cart')->create();
        $customer = $this->getReference('customer-1');
        $emptyCart->setCustomer($customer);

        $manager->persist($emptyCart);

        $fullCart = $this->container->get('elcodi.core.cart.factory.cart')->create();
        $customer = $this->getReference('customer-2');
        $fullCart->setCustomer($customer);

        $cartLine1 = $this->container->get('elcodi.core.cart.factory.cart_line')->create();
        $fullCart->addCartLine($cartLine1);
        $cartLine1
            ->setProduct($this->getReference('product-ibiza-4-ever'))
            ->setProductAmount($this->getReference('product-ibiza-4-ever')->getPrice())
            ->setAmount($this->getReference('product-ibiza-4-ever')->getPrice())
            ->setQuantity(2)
            ->setCart($fullCart);

        $cartLine2 = $this->container->get('elcodi.core.cart.factory.cart_line')->create();
        $fullCart->addCartLine($cartLine2);
        $cartLine2
            ->setProduct($this->getReference('product-star-amnesia'))
            ->setProductAmount($this->getReference('product-star-amnesia')->getPrice())
            ->setAmount($this->getReference('product-star-amnesia')->getPrice())
            ->setQuantity(2)
            ->setCart($fullCart);

        $manager->persist($fullCart);

        $manager->flush();
    }

    /**
     * Order for given fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 6;
    }
}
