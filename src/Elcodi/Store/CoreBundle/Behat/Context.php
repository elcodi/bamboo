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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Store\CoreBundle\Behat;

use Behat\Mink\Exception\ElementHtmlException;
use Behat\Mink\Exception\ElementNotFoundException;
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

    /**
     * @When /^the page contains a "(?P<value>[^"]*)" test attribute$/
     * @Then /^the response should contain a "(?P<value>[^"]*)" test attribute$/
     */
    public function responseShouldContainTestAttribute($value)
    {
        $session = $this
            ->getSession();

        $page = $session
            ->getPage();

        $testAttribute = $page
            ->find(
                'xpath',
                "//*[@data-test='$value']"
            );

        if ($testAttribute == null) {
            throw new ElementNotFoundException(
                $session
            );
        }
    }

    /**
     * @When /^the page does not contain a "(?P<value>[^"]*)" test attribute$/
     * @Then /^the response should not contain a "(?P<value>[^"]*)" test attribute$/
     */
    public function responseShouldNotContainTestAttribute($value)
    {
        $session = $this
            ->getSession();

        $page = $session
            ->getPage();

        $testAttribute = $page
            ->find(
                'xpath',
                "//*[@data-test='$value']"
            );

        if ($testAttribute !== null) {
            throw new ElementHtmlException(
                "Found element attribute with value: $value",
                $session,
                $testAttribute
            );
        }
    }


}
