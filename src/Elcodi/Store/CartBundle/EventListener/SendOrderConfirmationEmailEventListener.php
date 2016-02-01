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

namespace Elcodi\Store\CartBundle\EventListener;

use Elcodi\Component\Cart\Event\OrderOnCreatedEvent;
use Elcodi\Store\PageBundle\EventListener\Abstracts\AbstractEmailSenderEventListener;

/**
 * Class SendOrderConfirmationEmailEventListener
 */
class SendOrderConfirmationEmailEventListener extends AbstractEmailSenderEventListener
{
    /**
     * Send email
     *
     * @param OrderOnCreatedEvent $event Event
     */
    public function sendOrderConfirmationEmail(OrderOnCreatedEvent $event)
    {
        $order = $event->getOrder();
        $customer = $order->getCustomer();

        $this->sendEmail(
            'order_confirmation',
            [
                'order'    => $order,
                'customer' => $customer,
            ],
            $customer->getEmail()
        );
    }
}
