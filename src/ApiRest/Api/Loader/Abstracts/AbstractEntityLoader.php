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

namespace ApiRest\Api\Loader\Abstracts;

use ApiRest\Api\Configuration\ApiRestConfiguration;
use ApiRest\Api\Configuration\ApiRestConfigurationCollector;
use ApiRest\Api\EventDispatcher\ApiRestEventDispatcher;
use ApiRest\Api\Mapping\MappingInfoProvider;
use ApiRest\Api\Normalizer\FieldNormalizer;
use Elcodi\Component\Core\Services\RepositoryProvider;
use JMS\Serializer\SerializerBuilder;

/**
 * Class AbstractEntityLoader
 */
abstract class AbstractEntityLoader
{
    /**
     * @var RepositoryProvider
     *
     * Repository provider
     */
    protected $repositoryProvider;

    /**
     * @var MappingInfoProvider
     *
     * Mapping info provider
     */
    protected $mappingInfoProvider;

    /**
     * @var ApiRestConfigurationCollector
     *
     * Configuration
     */
    protected $configuration;

    /**
     * @var ApiRestEventDispatcher
     *
     * Event dispatcher
     */
    protected $eventDispatcher;

    /**
     * Constructor
     *
     * @param RepositoryProvider            $repositoryProvider  Repository provider
     * @param MappingInfoProvider           $mappingInfoProvider Mapping info provider
     * @param ApiRestConfigurationCollector $configuration       Configuration
     * @param ApiRestEventDispatcher        $eventDispatcher     Event Dispatcher
     */
    function __construct(
        RepositoryProvider $repositoryProvider,
        MappingInfoProvider $mappingInfoProvider,
        ApiRestConfigurationCollector $configuration,
        ApiRestEventDispatcher $eventDispatcher
    )
    {
        $this->repositoryProvider = $repositoryProvider;
        $this->mappingInfoProvider = $mappingInfoProvider;
        $this->configuration = $configuration;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Load entity given its instance
     *
     * @param ApiRestConfiguration $entityConfiguration Entity configuration
     * @param mixed                $entity              Entity instance
     *
     * @return array Entity information or false if not found
     */
    protected function loadEntity(
        ApiRestConfiguration $entityConfiguration,
        $entity
    )
    {
        $serializer = SerializerBuilder::create()->build();
        $entityAsArray = $serializer->toArray($entity);
        $entityAlias = $entityConfiguration->getEntityAlias();
        $entityIdentifierField = $this
            ->mappingInfoProvider
            ->getEntityIdentifierByNamespace(
                $entityConfiguration->getEntityNamespace()
            );
        $entityId = $entityAsArray[$entityIdentifierField];

        $data = [
            'type'       => $entityAlias,
            'id'         => $entityId,
            'attributes' => array_intersect_key(
                $entityAsArray,
                array_flip(
                    $this
                        ->mappingInfoProvider
                        ->getEntityMappingAttributesByAlias($entityAlias)
                )
            ),
        ];

        return array_merge(
            $data,
            $this->loadEntityRelationShips(
                $entityConfiguration,
                $entityAsArray
            )
        );
    }

    /**
     * Load entity relationships
     *
     * @param ApiRestConfiguration $entityConfiguration Entity configuration
     * @param mixed                $entityAsArray       Entity as array
     *
     * @return array Entity relationships
     */
    private function loadEntityRelationShips(
        ApiRestConfiguration $entityConfiguration,
        $entityAsArray
    )
    {
        $entityAlias = $entityConfiguration->getEntityAlias();
        $entityNamespace = $entityConfiguration->getEntityNamespace();
        $data = [
            'relationships' => [],
            'meta'          => [],
        ];

        $relationships = $this
            ->mappingInfoProvider
            ->getEntityMappingRelationshipsByNamespace($entityNamespace);

        /**
         * Each relationship is fetched and processed
         *
         * At this point we don't really know if each one of them can be treated
         * as a relationship (entity supported in this API) or must be an api.
         */
        foreach ($relationships as $relationship) {

            $relationshipNormalized = FieldNormalizer::normalize($relationship);

            /**
             * Relation supported, but the actual entity does not have any data
             * inside. Because when an association disappears as soon as has no
             * data, we should continue with next field.
             */
            if (!isset($entityAsArray[$relationshipNormalized])) {

                continue;
            }

            $relationshipNamespace = $this
                ->mappingInfoProvider
                ->getEntityMappingRelationshipNamespaceByAlias(
                    $entityAlias,
                    $relationship
                );

            /**
             * Relation not supported
             */
            if (false === $relationshipNamespace) {

                // NOT SUPPORTED => Go to meta
            }

            /**
             * At this point we are sure that this object exists!
             *
             * @var ApiRestConfiguration $relationshipConfiguration
             */
            $relationshipConfiguration = $this
                ->configuration
                ->getEntityConfigurationByNamespace($relationshipNamespace);

            /**
             * We get the first identifier. Because this API works with only 1
             * identifier, we will believe that the first one is the only one.
             */
            $identifier = $this
                ->mappingInfoProvider
                ->getEntityMappingRelationshipIdentifierByNamespace(
                    $entityNamespace,
                    $relationship
                );

            $isArray = !isset($entityAsArray[$relationshipNormalized][$identifier]);

            if ($relationshipConfiguration instanceof ApiRestConfiguration) {

                $relationshipAlias = $relationshipConfiguration->getEntityAlias();
                $relationshipData = ['data' => []];
                if ($isArray) {
                    foreach ($entityAsArray[$relationshipNormalized] as $relationshipElement) {
                        $relationshipData['data'] = [
                            'type' => $relationshipAlias,
                            'id'   => $relationshipElement[$identifier],
                        ];
                    }
                } else {
                    $relationshipData['data'] = [
                        'type' => $relationshipAlias,
                        'id'   => $entityAsArray[$relationshipNormalized][$identifier],
                    ];
                }

                $data['relationships'][$relationshipNormalized] = $relationshipData;
            } else {
                $metaData = [];
                if ($isArray) {
                    foreach ($entityAsArray[$relationshipNormalized] as $relationshipElement) {
                        $metaData[] = $relationshipElement[$identifier];
                    }
                } else {
                    $metaData = $entityAsArray[$relationshipNormalized][$identifier];
                }

                $data['meta'][$relationshipNormalized] = $metaData;
            }
        }

        return array_filter($data);
    }
}
