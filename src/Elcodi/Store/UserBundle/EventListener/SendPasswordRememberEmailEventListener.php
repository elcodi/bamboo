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

namespace Elcodi\Store\UserBundle\EventListener;

use Elcodi\Component\User\Event\PasswordRememberEvent;
use Elcodi\Store\PageBundle\EventListener\Abstracts\AbstractEmailSenderEventListener;

/**
 * Class SendPasswordRememberEmailEventListener
 */
class SendPasswordRememberEmailEventListener extends AbstractEmailSenderEventListener
{
    /**
     * Send email
     *
     * @param PasswordRememberEvent $event Event
     */
    public function sendPasswordRememberEmail(PasswordRememberEvent $event)
    {
        $customer = $event->getUser();
        $rememberUrl = $event->getRememberUrl();

        $this->sendEmail(
            'password_remember',
            [
                'customer'     => $customer,
                'remember_url' => $rememberUrl,
            ],
            $customer->getEmail()
        );
    }
}
