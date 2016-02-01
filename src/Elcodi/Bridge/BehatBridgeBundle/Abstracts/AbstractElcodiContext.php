<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi.com
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

namespace Elcodi\Bridge\BehatBridgeBundle\Abstracts;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
}
