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

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\StateTransitionMachine\Event\TransitionEvent;
use Elcodi\Store\PageBundle\EventListener\Abstracts\AbstractEmailSenderEventListener;

/**
 * Class SendOrderShippedEmailEventListener
 */
class SendOrderShippedEmailEventListener extends AbstractEmailSenderEventListener
{
    /**
     * Send email
     *
     * @param TransitionEvent $event Event
     */
    public function sendOrderShippedEmail(TransitionEvent $event)
    {
        /**
         * @var OrderInterface $order
         */
        $order = $event->getObject();
        $customer = $order->getCustomer();

        $this->sendEmail(
            'order_shipped',
            [
                'order'    => $order,
                'customer' => $customer,
            ],
            $customer->getEmail()
        );
    }
}
