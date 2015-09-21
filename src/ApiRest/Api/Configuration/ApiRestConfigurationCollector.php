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
 
namespace ApiRest\Api\Configuration;

/**
 * Class ApiRestConfigurationCollector
 */
class ApiRestConfigurationCollector
{
    /**
     * @var ApiRestConfiguration[]
     *
     * ApiRest Configuration
     */
    private $apiRestConfigurations = [];

    /**
     * @var string
     *
     * Route format
     */
    private $routeFormat;

    /**
     * Constructor
     *
     * @param string $routeFormat Route format
     */
    function __construct($routeFormat)
    {
        $this->routeFormat = $routeFormat;
    }

    /**
     * Add an ApiRestConfiguration instance
     *
     * @param ApiRestConfiguration $apiRestConfiguration ApiRest Configuration
     */
    public function addApiRestConfiguration(ApiRestConfiguration $apiRestConfiguration)
    {
        $this->apiRestConfigurations[$apiRestConfiguration->getEntityAlias()] = $apiRestConfiguration;
    }

    /**
     * Get entity configurations
     *
     * @return ApiRestConfiguration[] Configurations
     */
    public function getEntityConfigurations()
    {
        return $this->apiRestConfigurations;
    }

    /**
     * Get entity configuration given its alias
     *
     * @param string $entityAlias Entity alias
     *
     * @return ApiRestConfiguration Entity configuration
     */
    public function getEntityConfigurationByAlias($entityAlias)
    {
        return isset($this->apiRestConfigurations[$entityAlias])
            ? $this->apiRestConfigurations[$entityAlias]
            : false;
    }

    /**
     * Get entity configuration given its alias
     *
     * If is not found, return null
     *
     * @param string $entityNamespace Entity namespace
     *
     * @return ApiRestConfiguration|false Entity configuration
     */
    public function getEntityConfigurationByNamespace($entityNamespace)
    {
        foreach ($this->apiRestConfigurations as $apiRestConfiguration) {

            if ($apiRestConfiguration->getEntityNamespace() === $entityNamespace) {

                return $apiRestConfiguration;
            }
        }

        return false;
    }
}
