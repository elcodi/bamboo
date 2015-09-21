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
 * Class EntityRelationshipRootLinksDecorator
 */
class EntityRelationshipRootLinksDecorator implements Decorator
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
        $event->addResponseLinks([
            'related' => $this
                ->routesBuilder
                ->getRoutePathByEntityAlias(
                    $event->getEntityAlias(),
                    [
                        'id' => $event->getEntityId(),
                    ]
                )
        ]);
    }
}
