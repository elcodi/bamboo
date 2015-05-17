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
     * @var ContainerAwareEventDispatcher
     *
     * Event dispatcher
     */
    protected $eventDispatcher;

    /**
     * @var array
     *
     * Listeners to attach on firewall activation
     */
    protected $listenerIds = [];

    /**
     * Construct
     *
     * @param EventDispatcherInterface $eventDispatcher Dispatcher
     * @param array                    $listenerIds     Listener ids
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        $listenerIds = []
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->listenerIds = $listenerIds;
    }

    /**
     * This interface must be implemented by firewall listeners.
     *
     * @param GetResponseEvent $event Event
     */
    public function handle(GetResponseEvent $event)
    {
        /**
         * It may be a `TraceableEventDispatcher` in debug mode, so no hard
         * check in type
         */
        if (!is_callable([$this->eventDispatcher, 'addListenerService'])) {
            return null;
        }

        foreach ($this->listenerIds as $listener) {
            $this
                ->eventDispatcher
                ->addListenerService(
                    $listener['eventName'],
                    $listener['callback'],
                    $listener['priority']
                );
        }
    }
}
