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

namespace ApiRest\Api\Firewall;

use ApiRest\Api\Configuration\ApiRestConfiguration;
use ApiRest\Api\Configuration\ApiRestConfigurationCollector;
use ApiRest\Api\Event\ApiRestEvent;
use ApiRest\Api\Mapping\MappingInfoProvider;

/**
 * Class ResourceRelationshipFirewall
 */
class ResourceRelationshipFirewall implements Firewall
{
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
     * Constructor
     *
     * @param MappingInfoProvider           $mappingInfoProvider Mapping info provider
     * @param ApiRestConfigurationCollector $configuration       Configuration
     */
    function __construct(
        MappingInfoProvider $mappingInfoProvider,
        ApiRestConfigurationCollector $configuration
    )
    {
        $this->mappingInfoProvider = $mappingInfoProvider;
        $this->configuration = $configuration;
    }

    /**
     * Check content type.
     *
     * @param ApiRestEvent $event Event
     */
    public function filter(ApiRestEvent $event)
    {
        $entityNamespace = $event->getEntityNamespace();

        $relationshipNamespace = $this
            ->mappingInfoProvider
            ->getEntityMappingRelationshipNamespaceByNamespace(
                $entityNamespace,
                $event->getEntityRelationship()
            );

        $entityConfiguration = $this
            ->configuration
            ->getEntityConfigurationByNamespace($relationshipNamespace);

        if (!$entityConfiguration instanceof ApiRestConfiguration) {

            $event->resolveWithResourceNotFound();

            return;
        }
    }
}
