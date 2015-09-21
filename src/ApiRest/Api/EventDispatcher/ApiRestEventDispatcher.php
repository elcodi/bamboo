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

namespace ApiRest\Api\EventDispatcher;

use ApiRest\Api\Configuration\ApiRestConfiguration;
use ApiRest\Api\Event\ApiRestEvent;
use ApiRest\Api\Event\QueryBuilderEvent;
use Doctrine\ORM\QueryBuilder;
use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiRestEventDispatcher
 */
final class ApiRestEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Create all event related to api_rest and defined environment
     *
     * api_rest.{verb}
     * api_rest.{verb}.{entityAlias} if one entity
     * api_rest.{verb}.{entityAlias}.bulk if many entities
     *
     * @param Request                   $request             Request
     * @param ApiRestConfiguration|null $entityConfiguration Entity configuration
     * @param string                    $verb                Verb
     * @param mixed                     $entityId            Entity id
     * @param string                    $entityRelationship  Relationship
     *
     * @return ApiRestEvent Created event
     */
    public function createApiRestEvent(
        Request $request,
        $entityConfiguration,
        $verb,
        $entityId,
        $entityRelationship
    )
    {
        $verb = strtolower($verb);
        $entityAlias = strtolower($entityConfiguration->getEntityAlias());
        $event = new ApiRestEvent(
            $request,
            $entityConfiguration,
            $verb,
            $entityId,
            $entityRelationship
        );

        $verbEventName = 'api_rest.' . $verb;
        if (false == $entityId) {
            $verbEventName .= '_bulk';
        } elseif ($entityRelationship) {
            $verbEventName .= '_relationship';
        }

        $this
            ->eventDispatcher
            ->dispatch($verbEventName, $event);

        /**
         * If an event listener has stopped the propagation, just exit the
         * dispatches
         */
        if ($event->isPropagationStopped()) {

            return $event;
        }

        $entityEventName = $verbEventName . '.' . $entityAlias;
        $this
            ->eventDispatcher
            ->dispatch($entityEventName, $event);

        return $event;
    }

    /**
     * Create a query builder creation event
     *
     * @param ApiRestEvent $apiRestEvent Api Rest Event
     * @param QueryBuilder $queryBuilder Query Builder
     *
     * @return QueryBuilder Query builder
     */
    public function createQueryBuilderEvent(
        ApiRestEvent $apiRestEvent,
        QueryBuilder $queryBuilder
    ) {
        $this
            ->eventDispatcher
            ->dispatch('api_rest.query_builder', new QueryBuilderEvent(
                $apiRestEvent,
                $queryBuilder
            ));

        return $queryBuilder;
    }
}
