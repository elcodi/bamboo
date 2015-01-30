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

namespace Elcodi\Store\CoreBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class StoreUnavailableEventListener
 */
class StoreUnavailableEventListener
{
    /**
     * @var EngineInterface
     *
     * Template engine
     */
    protected $templateEngine;

    /**
     * @var boolean
     *
     * Store is available
     */
    protected $isAvailable;

    /**
     * @var string
     *
     * Template
     */
    protected $templatePath;

    /**
     * @var string
     *
     * Admin prefix
     */
    protected $adminPrefix;

    /**
     * Constructor
     *
     * @param EngineInterface $templateEngine Template engine
     * @param string          $templatePath   Template
     * @param boolean         $isAvailable    Store is available
     * @param string          $adminPrefix    Admin prefix
     */
    public function __construct(
        EngineInterface $templateEngine,
        $templatePath,
        $isAvailable,
        $adminPrefix
    )
    {
        $this->templateEngine = $templateEngine;
        $this->templatePath = $templatePath;
        $this->isAvailable = $isAvailable;
        $this->adminPrefix = $adminPrefix;
    }

    /**
     * Check if store is enabled
     *
     * @param GetResponseEvent $event Event
     *
     * @return Response
     */
    public function redirectWhenUnavailable(GetResponseEvent $event)
    {
        if ($this->isAvailable) {
            return;
        }

        $inStore = $this
            ->inStore(
                $event->getRequest(),
                $this->adminPrefix
            );

        if (!$inStore) {
            return;
        }

        $data = $this
            ->templateEngine
            ->render($this->templatePath);

        $response = new Response($data, Response::HTTP_SERVICE_UNAVAILABLE);
        $event->setResponse($response);
    }

    /**
     * Check if current request is in store
     *
     * @param Request $request     Request
     * @param string  $adminPrefix Admin prefix
     *
     * @return boolean In store
     */
    protected function inStore(Request $request, $adminPrefix)
    {
        $route = $request->getRequestUri();

        return 0 === preg_match('(_(profiler|wdt)|css|images|js|' . $adminPrefix . ')', $route);
    }
}
