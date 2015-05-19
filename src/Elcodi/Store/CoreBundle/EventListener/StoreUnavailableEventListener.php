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

use Elcodi\Component\Store\Entity\Interfaces\StoreInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;

/**
 * Class StoreUnavailableEventListener
 */
class StoreUnavailableEventListener implements ListenerInterface
{
    /**
     * @var StoreInterface
     *
     * Store
     */
    protected $store;

    /**
     * @var string
     *
     * Message string when not available
     */
    protected $message;

    /**
     * Constructor
     *
     * @param StoreInterface $store Store
     * @param string         $message          Error message
     */
    public function __construct(
        StoreInterface $store,
        $message = ''
    )
    {
        $this->store = $store;
        $this->message = $message;
    }

    /**
     * Throws an exception when the store is not available
     *
     * @param GetResponseEvent $event Event
     *
     * @throws ServiceUnavailableHttpException Service not available
     */
    public function handle(GetResponseEvent $event)
    {
        if (
            !$this->store->isEnabled() ||
            $this->store->isUnderConstruction()
        ) {
            throw new ServiceUnavailableHttpException(null, $this->message);
        }
    }
}
