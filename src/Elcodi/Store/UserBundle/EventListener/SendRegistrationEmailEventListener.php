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

use Elcodi\Component\User\Event\CustomerRegisterEvent;
use Elcodi\Store\PageBundle\EventListener\Abstracts\AbstractEmailSenderEventListener;

/**
 * Class SendRegistrationEmailEventListener
 */
class SendRegistrationEmailEventListener extends AbstractEmailSenderEventListener
{
    /**
     * Send email
     *
     * @param CustomerRegisterEvent $event Event
     */
    public function sendCustomerRegistrationEmail(CustomerRegisterEvent $event)
    {
        $customer = $event->getCustomer();

        $this->sendEmail(
            'customer_registration',
            [
                'customer' => $customer,
            ],
            $customer->getEmail()
        );
    }
}
