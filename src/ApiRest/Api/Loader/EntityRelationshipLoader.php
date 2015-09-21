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

namespace ApiRest\Api\Loader;

use ApiRest\Api\Event\ApiRestEvent;
use ApiRest\Api\Loader\Abstracts\AbstractEntityLoader;
use ApiRest\Api\Normalizer\FieldNormalizer;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class EntityRelationshipLoader
 */
class EntityRelationshipLoader extends AbstractEntityLoader implements Loader
{
    /**
     * Load the data
     *
     * @param ApiRestEvent $event Event
     */
    public function load(ApiRestEvent $event)
    {
        $entityId = $event->getEntityId();
        $entityNamespace = $event->getEntityNamespace();
        $relationshipNamespace = $this
            ->mappingInfoProvider
            ->getEntityMappingRelationshipNamespaceByNamespace(
                $entityNamespace,
                $event->getEntityRelationship()
            );

        $entity = $this
            ->repositoryProvider
            ->getRepositoryByEntityNamespace($entityNamespace)
            ->find($entityId);


        $denormalizedRelationship = FieldNormalizer::denormalize(
            $event->getEntityRelationship()
        );

        $inversedFieldName = $this
            ->mappingInfoProvider
            ->getAssociationMappedByTargetFieldByNamespace(
                $entityNamespace,
                $denormalizedRelationship
            );

        $queryBuilder = $this
            ->repositoryProvider
            ->getRepositoryByEntityNamespace($relationshipNamespace)
            ->createQueryBuilder('x')
            ->where('x.' . $inversedFieldName . ' = :element')
            ->setParameter('element', $entity);

        $this
            ->eventDispatcher
            ->createQueryBuilderEvent(
                $event,
                $queryBuilder
            );

        $relationship = $queryBuilder
            ->getQuery()
            ->getResult();

        $entityConfiguration = $this
            ->configuration
            ->getEntityConfigurationByNamespace($relationshipNamespace);

        $data = (is_array($relationship))
            ? $this->loadRelationshipCollection($entityConfiguration, $relationship)
            : $this->loadRelationshipEntity($entityConfiguration, $relationship);

        $event->addResponseData($data);
    }

    /**
     *
     */
    private function loadRelationshipCollection($entityConfiguration, $entities)
    {
        $data = [];
        foreach ($entities as $relationship) {

            $data[] = $this->loadEntity(
                $entityConfiguration,
                $relationship
            );
        }

        return $data;
    }

    /**
     *
     */
    private function loadRelationshipEntity($entityConfiguration, $entity)
    {
        if (null === $entity) {

            return null;
        }

        return $this->loadEntity(
            $entityConfiguration,
            $entity
        );
    }
}
