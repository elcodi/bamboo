<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Store\CoreBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;

/**
 * Class StoreUnavailableEventListener
 */
class StoreUnavailableEventListener implements ListenerInterface
{
    /**
     * @var boolean
     *
     * Store is available
     */
    protected $isAvailable;

    /**
     * @var string
     *
     * Message string when not available
     */
    protected $message;

    /**
     * Constructor
     *
     * @param boolean $isAvailable Store is available
     * @param string  $message     Error message
     */
    public function __construct($isAvailable, $message = '')
    {
        $this->isAvailable = $isAvailable;
        $this->message = $message;
    }

    /**
     * This interface must be implemented by firewall listeners.
     *
     * @param GetResponseEvent $event
     */
    public function handle(GetResponseEvent $event)
    {
        if ($this->isAvailable) {
            return;
        }

        throw new ServiceUnavailableHttpException(null, $this->message);
    }
}
