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

namespace Elcodi\Store\CoreBundle\Behat;

use Elcodi\Bridge\BehatBridgeBundle\Abstracts\AbstractElcodiContext;

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
        $this->theStoreIsEnabled(false);
    }

    /**
     * @Given /^the store is enabled$/
     */
    public function theStoreIsEnabled($enabled = true)
    {
        $store = $this
            ->getContainer()
            ->get('elcodi.store');

        $store->setEnabled($enabled);

        $this
            ->getContainer()
            ->get('elcodi.object_manager.store')
            ->flush($store);
    }

    /**
     * @Given /^(?:|I )am logged as "(?P<username>[^"]*)" - "(?P<password>[^"]*)"$/
     * @When /^(?:|I )log in as "(?P<username>[^"]*)" - "(?P<password>[^"]*)"$/
     */
    public function iAmLoggedAs($username, $password)
    {
        $this->visitPath('/login');

        $page = $this
            ->getSession()
            ->getPage();

        $page->fillField('store_user_form_type_login_email', $username);
        $page->fillField('store_user_form_type_login_password', $password);
        $page->pressButton('store_user_form_type_login_send');
    }
}
