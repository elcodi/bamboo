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

use ApiRest\Api\Configuration\ApiRestConfigurationCollector;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class RoutesBuilder
 */
class RoutesBuilder
{
    /**
     * @var UrlGeneratorInterface
     *
     * Url generator
     */
    private $urlGenerator;

    /**
     * @var ApiRestConfigurationCollector
     *
     * Configuration
     */
    private $configuration;

    /**
     * @var string
     *
     * Route format
     */
    private $routeFormat;

    /**
     * Construct
     *
     * @param UrlGeneratorInterface         $urlGenerator  Url generator
     * @param ApiRestConfigurationCollector $configuration Configuration
     * @param string                        $routeFormat   Route format
     */
    function __construct(
        UrlGeneratorInterface $urlGenerator,
        ApiRestConfigurationCollector $configuration,
        $routeFormat
    )
    {
        $this->urlGenerator = $urlGenerator;
        $this->configuration = $configuration;
        $this->routeFormat = $routeFormat;
    }


    /**
     * Build route name given the entity alias
     *
     * @param string $entityAlias Entity alias
     *
     * @return string Route name
     */
    public function getRouteNameByEntityAlias($entityAlias)
    {
        return str_replace(
            [
                '{entity}',
            ],
            [
                $entityAlias,
            ],
            $this->routeFormat
        );
    }

    /**
     * Build route path given the entity alias
     *
     * @param string $entityAlias Entity alias
     * @param array  $parameters  Parameters
     *
     * @return string Route name
     */
    public function getRoutePathByEntityAlias(
        $entityAlias,
        array $parameters = []
    )
    {
        $routeName = $this->getRouteNameByEntityAlias($entityAlias);

        return $this
            ->urlGenerator
            ->generate(
                $routeName,
                $parameters,
                UrlGeneratorInterface::ABSOLUTE_URL
            );
    }
}
