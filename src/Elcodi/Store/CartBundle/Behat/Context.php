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

namespace Elcodi\Store\CartBundle\Behat;

use Elcodi\Bridge\BehatBridgeBundle\Abstracts\AbstractElcodiContext;

/**
 * Class Context
 */
class Context extends AbstractElcodiContext
{
    /**
     * @Given /^I have an empty cart$/
     * @When /^I empty my cart$/
     */
    public function IEmptyMyCart()
    {
        $this->visitPath('/cart/empty');
    }

    /**
     * @When /^I add product "(?P<productId>\d+)" in my cart$/
     */
    public function iAddProductInCart($productId)
    {
        $this->visitPath('/cart/product/' . $productId . '/add');
    }

    /**
     * @When /^I remove line "(?P<lineId>\d+)" from my cart$/
     */
    public function iRemoveLineFromCart($lineId)
    {
        $this->visitPath('/cart/line/' . $lineId . '/remove');
    }
}
