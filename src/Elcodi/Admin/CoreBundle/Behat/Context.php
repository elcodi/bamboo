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

namespace Elcodi\Admin\CoreBundle\Behat;

use Elcodi\Bridge\BehatBridgeBundle\Abstracts\AbstractElcodiContext;

/**
 * Class Context
 */
class Context extends AbstractElcodiContext
{
    /**
     * @Given /^In admin, I am logged as "(?P<username>[^"]*)" - "(?P<password>[^"]*)"$/
     * @When /^In admin, I log in as "(?P<username>[^"]*)" - "(?P<password>[^"]*)"$/
     */
    public function inAdminIAmLoggedAs($username, $password)
    {
        $this->visitPath('/admin/login');

        $page = $this
            ->getSession()
            ->getPage();

        $page->fillField('elcodi_admin_user_form_type_login_email', $username);
        $page->fillField('elcodi_admin_user_form_type_login_password', $password);
        $page->pressButton('submit-login');
    }
}
