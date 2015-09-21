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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace ApiRest\Api\Controller;

use ApiRest\Api\Configuration\ApiRestConfigurationCollector;
use ApiRest\Api\EventDispatcher\ApiRestEventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class ApiRestController
 */
class ApiRestController
{
    /**
     * @var RequestStack
     *
     * Request stack
     */
    private $requestStack;

    /**
     * @var ApiRestEventDispatcher
     *
     * Event Dispatcher
     */
    private $eventDispatcher;

    /**
     * @var ApiRestConfigurationCollector
     *
     * Api rest configuration
     */
    private $configuration;

    /**
     * Constructor
     *
     * @param RequestStack                  $requestStack    Request stack
     * @param ApiRestEventDispatcher        $eventDispatcher Event Dispatcher
     * @param ApiRestConfigurationCollector $configuration   Configuration
     */
    public function __construct(
        RequestStack $requestStack,
        ApiRestEventDispatcher $eventDispatcher,
        ApiRestConfigurationCollector $configuration)
    {
        $this->requestStack = $requestStack;
        $this->eventDispatcher = $eventDispatcher;
        $this->configuration = $configuration;
    }

    /**
     * Do action
     *
     * This method works as a simple entry point
     *
     * @param string $entityAlias  Entity alias
     * @param mixed  $id           Entity id
     * @param string $relationship Relationship
     *
     * @return JsonResponse Response
     */
    public function handle(
        $entityAlias,
        $id = null,
        $relationship = null
    )
    {
        $entityConfiguration = $this
            ->configuration
            ->getEntityConfigurationByAlias($entityAlias);

        $request = $this
            ->requestStack
            ->getCurrentRequest();

        $verb = strtolower($request->getMethod());

        $event = $this
            ->eventDispatcher
            ->createApiRestEvent(
                $request,
                $entityConfiguration,
                $verb,
                $id,
                $relationship
            );

        return new JsonResponse(
            $event->getResponseContent(),
            $event->getResponseStatus(),
            $event->getResponseHeaders()
        );
    }
}
