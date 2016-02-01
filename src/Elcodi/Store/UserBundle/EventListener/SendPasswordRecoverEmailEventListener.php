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

use Elcodi\Component\User\Event\PasswordRecoverEvent;
use Elcodi\Store\PageBundle\EventListener\Abstracts\AbstractEmailSenderEventListener;

/**
 * Class SendPasswordRecoverEmailEventListener
 */
class SendPasswordRecoverEmailEventListener extends AbstractEmailSenderEventListener
{
    /**
     * Send email
     *
     * @param PasswordRecoverEvent $event Event
     */
    public function sendPasswordRecoverEmail(PasswordRecoverEvent $event)
    {
        $customer = $event->getUser();

        $this->sendEmail(
            'password_recover',
            [
                'customer'     => $customer,
            ],
            $customer->getEmail()
        );
    }
}
