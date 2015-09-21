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
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use ApiRest\Api\Configuration\ApiRestConfiguration;
use ApiRest\Api\Configuration\ApiRestConfigurationCollector;
use ApiRest\Api\Mapping\MappingInfoProvider;
use ApiRest\Api\Router\RoutesBuilder;

/**
 * Class EntityRelationshipsLinksDecorator
 */
class EntityRelationshipsLinksDecorator implements Decorator
{
    /**
     * @var RoutesBuilder
     *
     * Routes Builder
     */
    private $routesBuilder;

    /**
     * @var ApiRestConfigurationCollector
     *
     * Configuration
     */
    private $configuration;

    /**
     * @var MappingInfoProvider
     *
     * Mapping info provider
     */
    private $mappingInfoProvider;

    /**
     * Constructor
     *
     * @param RoutesBuilder                 $routesBuilder       Routes Builder
     * @param ApiRestConfigurationCollector $configuration       Configuration
     * @param MappingInfoProvider           $mappingInfoProvider Mapping info provider
     */
    function __construct(
        RoutesBuilder $routesBuilder,
        ApiRestConfigurationCollector $configuration,
        MappingInfoProvider $mappingInfoProvider
    )
    {
        $this->routesBuilder = $routesBuilder;
        $this->configuration = $configuration;
        $this->mappingInfoProvider = $mappingInfoProvider;
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
        if (isset($data['relationships']) && is_array($data['relationships'])) {
            foreach ($data['relationships'] as $relationshipPosition => $relationship) {
                if (!isset($relationship['links'])) {
                    $data['relationships'][$relationshipPosition]['links'] = [];
                }

                $data['relationships'][$relationshipPosition]['links'] = array_merge(
                    $data['relationships'][$relationshipPosition]['links'],
                    [
                        'self' => $this
                            ->routesBuilder
                            ->getRoutePathByEntityAlias(
                                $data['type'],
                                [
                                    'id'           => $data['id'],
                                    'relationship' => $relationshipPosition
                                ]
                            )
                    ]
                );
            }
        }

        return $data;
    }
}
