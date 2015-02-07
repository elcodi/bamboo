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

namespace Elcodi\Common\FirewallBundle\EventListener;

use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;

/**
 * Class FirewallListener
 *
 * @author Berny Cantos <be@rny.cc>
 */
class FirewallListener implements ListenerInterface
{
    /**
     * @var array
     *
     * Listeners to attach on firewall activation
     */
    protected $listenerIds = [];

    /**
     * @var ContainerAwareEventDispatcher
     *
     * Event dispatcher
     */
    protected $dispatcher;

    /**
     * @param EventDispatcherInterface $dispatcher
     * @param array                    $listener_ids
     */
    public function __construct(EventDispatcherInterface $dispatcher, $listener_ids = [])
    {
        $this->dispatcher = $dispatcher;
        $this->listenerIds = $listener_ids;
    }

    /**
     * This interface must be implemented by firewall listeners.
     *
     * @param GetResponseEvent $event
     */
    public function handle(GetResponseEvent $event)
    {
        // It may be a `TraceableEventDispatcher` in debug mode, so no hard check in type
        if (!is_callable(array($this->dispatcher, 'addListenerService'))) {
            return;
        }

        foreach ($this->listenerIds as $listener) {
            $this
                ->dispatcher
                ->addListenerService($listener['eventName'], $listener['callback'], $listener['priority']);
        }
    }
}
