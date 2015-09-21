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

namespace ApiRest\Api\Decorator;

use ApiRest\Api\Event\ApiRestEvent;
use ApiRest\Api\Router\RoutesBuilder;

/**
 * Class EntityLinksDecorator
 */
class EntityLinksDecorator implements Decorator
{
    /**
     * @var RoutesBuilder
     *
     * Routes Builder
     */
    protected $routesBuilder;

    /**
     * Constructor
     *
     * @param RoutesBuilder $routesBuilder Routes Builder
     */
    function __construct(RoutesBuilder $routesBuilder)
    {
        $this->routesBuilder = $routesBuilder;
    }

    /**
     * Decorates the event
     *
     * @param ApiRestEvent $event Event
     */
    public function decorate(ApiRestEvent $event)
    {
        $data = $event->getResponseData();

        $data = isset($data['type'])
            ? $this->decorateElement($data)
            : $this->decorateCollection($data);

        $event->setResponseData($data);
    }

    /**
     *
     */
    private function decorateCollection(array $data)
    {
        foreach ($data as $position => $element) {
            $data[$position] = $this->decorateElement($element);
        }

        return $data;
    }

    /**
     * Decorates an element with related links
     */
    private function decorateElement(array $data)
    {
        if (!isset($data['links']) || !is_array($data['links'])) {
            $data['links'] = [];
        }

        $data['links'] = array_merge(
            $data['links'],
            [
                'self' => $this
                    ->routesBuilder
                    ->getRoutePathByEntityAlias(
                        $data['type'],
                        [
                            'id' => $data['id'],
                        ]
                    )
            ]
        );

        return $data;
    }
}
