<?php

/*
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

namespace Elcodi\Store\CoreBundle\Behat;

use Elcodi\Store\CoreBundle\Behat\abstracts\AbstractElcodiContext;

/**
 * Class Context
 */
class Context extends AbstractElcodiContext
{
    /**
     * @Given /^the store is disabled$/
     */
    public function theStoreIsDisabled()
    {

        $this->setConfiguration('store.enabled', false);
    }

    /**
     * @Given /^the store is under construction$/
     */
    public function theStoreIsUnderConstruction()
    {
        $this->setConfiguration('store.under_construction', true);
    }
}
