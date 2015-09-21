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

namespace ApiRest\Api\Router;

use ApiRest\Api\ApiRoutes;
use ApiRest\Api\Configuration\ApiRestConfiguration;
use ApiRest\Api\Configuration\ApiRestConfigurationCollector;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RouteGenerator
 *
 * This class depends on a structure like this
 *
 * [
 *      "order" => [
 *          "api" => true,
 *          "namespace" => "My\Namespace\Order",
 *          "methods" => [
 *              "GET", "POST", "DELETE",
 *          ],
 *      ],
 * ]
 */
class RoutesLoader implements LoaderInterface
{
    /**
     * @var boolean
     *
     * Route is loaded
     */
    private $loaded = false;

    /**
     * @var ApiRestConfigurationCollector
     *
     * Configuration
     */
    private $configuration;

    /**
     * @var RoutesBuilder
     *
     * Router Builder
     */
    private $routesBuilder;

    /**
     * Construct
     *
     * @param ApiRestConfigurationCollector $configuration Configuration
     * @param RoutesBuilder                 $routesBuilder Router Builder
     */
    public function __construct(
        ApiRestConfigurationCollector $configuration,
        RoutesBuilder $routesBuilder
    )
    {
        $this->configuration = $configuration;
        $this->routesBuilder = $routesBuilder;
    }

    /**
     * Loads a resource.
     *
     * @param mixed       $resource The resource
     * @param string|null $type     The resource type or null if unknown
     *
     * @return RouteCollection
     *
     * @throws \Exception If something went wrong
     */
    public function load($resource, $type = null)
    {
        if ($this->loaded) {

            throw new \RuntimeException('Do not add this loader twice');
        }

        $routes = new RouteCollection();
        $entitiesConfiguration = $this
            ->configuration
            ->getEntityConfigurations();

        foreach ($entitiesConfiguration as $entityConfiguration) {

            if ($entityConfiguration->isEnabled()) {

                /**
                 * We load all REST routes
                 */
                $routes->addCollection(
                    $this->loadEntityRoutes($entityConfiguration)
                );
            }
        }

        $this->loaded = true;

        return $routes;
    }

    /**
     * Load entity routes but get route
     *
     * @param ApiRestConfiguration $entityConfiguration Entity configuration
     *
     * @return RouteCollection
     */
    private function loadEntityRoutes(ApiRestConfiguration $entityConfiguration)
    {
        $routes = new RouteCollection();

        $entityAlias = $entityConfiguration->getEntityAlias();
        $route = new Route(
            $entityAlias . '/{id}/{relationship}', [
            '_controller'  => 'api_rest.controller:handle',
            'id'           => false,
            'relationship' => false,
            'entityAlias'  => $entityAlias,
        ]);

        $routes
            ->add(
                $this
                    ->routesBuilder
                    ->getRouteNameByEntityAlias($entityAlias),
                $route
            );

        return $routes;
    }

    /**
     * Returns whether this class supports the given resource.
     *
     * @param mixed       $resource A resource
     * @param string|null $type     The resource type or null if unknown
     *
     * @return bool True if this class supports the given resource, false otherwise
     */
    public function supports($resource, $type = null)
    {
        return 'api' === $type;
    }

    /**
     * Gets the loader resolver.
     *
     * @return LoaderResolverInterface A LoaderResolverInterface instance
     */
    public function getResolver()
    {
    }

    /**
     * Sets the loader resolver.
     *
     * @param LoaderResolverInterface $resolver A LoaderResolverInterface instance
     */
    public function setResolver(LoaderResolverInterface $resolver)
    {
    }
}
