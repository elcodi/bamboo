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

namespace ApiRest\Api\Mapping;

use ApiRest\Api\Configuration\ApiRestConfiguration;
use ApiRest\Api\Configuration\ApiRestConfigurationCollector;
use ApiRest\Api\Normalizer\FieldNormalizer;
use Elcodi\Component\Core\Services\ManagerProvider;

/**
 * Class MappingInfoProvider
 */
class MappingInfoProvider
{
    /**
     * @var ManagerProvider
     *
     * Manager provider
     */
    private $managerProvider;

    /**
     * @var ApiRestConfigurationCollector
     *
     * configuration
     */
    private $configuration;

    /**
     * @param $managerProvider
     * @param $configuration
     */
    function __construct($managerProvider, $configuration)
    {
        $this->managerProvider = $managerProvider;
        $this->configuration = $configuration;
    }

    /**
     * Get entity mapping attributes by alias
     *
     * @param string $entityAlias Entity alias
     *
     * @return array|false attributes keys or false if missing
     */
    public function getEntityMappingAttributesByAlias($entityAlias)
    {
        $entityConfiguration = $this
            ->configuration
            ->getEntityConfigurationByAlias($entityAlias);

        if (!$entityConfiguration instanceof ApiRestConfiguration) {

            return false;
        }

        $entityNamespace = $entityConfiguration->getEntityNamespace();

        return $this->getEntityMappingAttributesByNamespace($entityNamespace);
    }

    /**
     * Get entity mapping attributes by namespace
     *
     * @param string $entityNamespace Entity namespace
     *
     * @return array|false attributes keys or false if missing
     */
    public function getEntityMappingAttributesByNamespace($entityNamespace)
    {
        return $this
            ->managerProvider
            ->getManagerByEntityNamespace($entityNamespace)
            ->getClassMetadata($entityNamespace)
            ->getFieldNames();
    }

    /**
     * Get entity mapping attributes by alias
     *
     * @param string $entityAlias Entity alias
     *
     * @return array attributes keys
     */
    public function getEntityMappingRelationshipsByAlias($entityAlias)
    {
        $entityConfiguration = $this
            ->configuration
            ->getEntityConfigurationByAlias($entityAlias);

        if (!$entityConfiguration instanceof ApiRestConfiguration) {

            return false;
        }

        $entityNamespace = $entityConfiguration->getEntityNamespace();

        return $this->getEntityMappingRelationshipsByNamespace($entityNamespace);
    }

    /**
     * Get entity mapping attributes by namespace
     *
     * @param string $entityNamespace Entity namespace
     *
     * @return array attributes keys
     */
    public function getEntityMappingRelationshipsByNamespace($entityNamespace)
    {
        return $this
            ->managerProvider
            ->getManagerByEntityNamespace($entityNamespace)
            ->getClassMetadata($entityNamespace)
            ->getAssociationNames();
    }

    /**
     * Get namespace of relationship by its name
     *
     * @param string $entityAlias Entity alias
     * @param string $fieldName   Field name
     *
     * @return string Namespace
     */
    public function getEntityMappingRelationshipNamespaceByAlias(
        $entityAlias,
        $fieldName
    )
    {
        $entityConfiguration = $this
            ->configuration
            ->getEntityConfigurationByAlias($entityAlias);

        if (!$entityConfiguration instanceof ApiRestConfiguration) {

            return false;
        }

        $entityNamespace = $entityConfiguration->getEntityNamespace();

        return $this
            ->getEntityMappingRelationshipNamespaceByNamespace(
                $entityNamespace,
                $fieldName
            );
    }

    /**
     * Get association target class given a namespace and the field name
     *
     * @param string $entityNamespace Entity namespace
     * @param string $fieldName       Field name
     *
     * @return string Namespace
     */
    public function getEntityMappingRelationshipNamespaceByNamespace(
        $entityNamespace,
        $fieldName
    )
    {
        $fieldName = FieldNormalizer::denormalize($fieldName);

        return $this
            ->managerProvider
            ->getManagerByEntityNamespace($entityNamespace)
            ->getClassMetadata($entityNamespace)
            ->getAssociationTargetClass($fieldName);
    }

    /**
     * Get namespace of relationship by its alias and the field name
     *
     * @param string $entityAlias Entity alias
     * @param string $fieldName   Field name
     *
     * @return string Namespace
     */
    public function getEntityMappingRelationshipIdentifierByAlias(
        $entityAlias,
        $fieldName
    )
    {
        $entityConfiguration = $this
            ->configuration
            ->getEntityConfigurationByAlias($entityAlias);

        if (!$entityConfiguration instanceof ApiRestConfiguration) {

            return false;
        }

        $entityNamespace = $entityConfiguration->getEntityNamespace();

        return $this->getEntityMappingRelationshipIdentifierByNamespace(
            $entityNamespace,
            $fieldName
        );
    }

    /**
     * Get namespace of relationship by its namespace and the field name
     *
     * @param string $entityNamespace Entity namespace
     * @param string $fieldName       Field name
     *
     * @return string Namespace
     */
    public function getEntityMappingRelationshipIdentifierByNamespace(
        $entityNamespace,
        $fieldName
    )
    {
        $relationshipNamespace = $this
            ->getEntityMappingRelationshipNamespaceByNamespace(
                $entityNamespace,
                $fieldName
            );

        return $this->getEntityIdentifierByNamespace($relationshipNamespace);
    }

    /**
     * Get identifier by namespace
     *
     * @param string $entityNamespace Entity namespace
     *
     * @return string Namespace
     */
    public function getEntityIdentifierByNamespace($entityNamespace)
    {
        $identifiers = $this
            ->managerProvider
            ->getManagerByEntityNamespace($entityNamespace)
            ->getClassMetadata($entityNamespace)
            ->getIdentifier();

        if (empty($identifiers)) {

            return false;
        }

        return reset($identifiers);
    }

    /**
     * Get the field name of association mapped by target
     *
     * @param string $entityNamespace Entity namespace
     * @param string $fieldName       Field name
     *
     * @return string Namespace
     */
    public function getAssociationMappedByTargetFieldByNamespace(
        $entityNamespace,
        $fieldName
    )
    {
        $fieldName = FieldNormalizer::denormalize($fieldName);

        return $this
            ->managerProvider
            ->getManagerByEntityNamespace($entityNamespace)
            ->getClassMetadata($entityNamespace)
            ->getAssociationMappedByTargetField($fieldName);
    }
}
