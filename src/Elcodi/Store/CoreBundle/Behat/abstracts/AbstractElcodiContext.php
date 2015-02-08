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
 */

namespace Elcodi\Store\CoreBundle\Behat\abstracts;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Elcodi\Component\Configuration\Exception\ConfigurationNotEditableException;
use Elcodi\Component\Configuration\Services\ConfigurationManager;

/**
 * Class AbstractElcodiContext
 */
class AbstractElcodiContext extends RawMinkContext implements Context, KernelAwareContext
{
    /**
     * @var KernelInterface
     *
     * Kernel
     */
    protected $kernel;

    /**
     * @var Application
     *
     * application
     */
    protected $application;

    /**
     * Sets Kernel instance.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        $this->application = new Application($this->kernel);
        $this->application->setAutoExit(false);
    }

    /**
     * Returns Container instance.
     *
     * @return ContainerInterface
     */
    protected function getContainer()
    {
        return $this
            ->kernel
            ->getContainer();
    }

    /**
     *
     * /**
     * Get url generator
     *
     * @return UrlGeneratorInterface Url generator
     */
    public function getUrlGenerator()
    {
        return $this
            ->getContainer()
            ->get('router');
    }

    /**
     * Get route given name and parameters
     *
     * @param string $routeName       Route name
     * @param array  $routeParameters Route parameters
     *
     * @return string Route path
     */
    public function getRoute($routeName, array $routeParameters = [])
    {
        return $this
            ->getUrlGenerator()
            ->generate($routeName, $routeParameters);
    }

    /**
     * Set a value in the configuration manager
     *
     * @param string $identifier Name of the setting in configuration
     * @param mixed  $newValue   New value
     *
     * @throws ConfigurationNotEditableException
     */
    protected function setConfiguration($identifier, $newValue)
    {
        $this
            ->getConfigurationManager()
            ->set($identifier, $newValue);
    }

    /**
     * Get configuration manager
     *
     * @return ConfigurationManager
     */
    protected function getConfigurationManager()
    {
        $manager = $this
            ->getContainer()
            ->get('elcodi.configuration_manager');

        return $manager;
    }
}
