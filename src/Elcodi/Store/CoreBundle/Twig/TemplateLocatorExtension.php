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

namespace Elcodi\Store\CoreBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class TemplateLocatorExtension
 */
class TemplateLocatorExtension extends Twig_Extension
{
    /**
     * @var ContainerInterface
     *
     * Container
     */
    protected $container;

    /**
     * Construct
     *
     * We inject the container because of a circular reference. ASAP this
     * injection should be removed and fixed
     *
     * @param ContainerInterface $container Container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Return all functions
     *
     * @return Twig_SimpleFunction[] Functions
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('locate_template', [$this, 'locateTemplate']),
        ];
    }

    /**
     * Return the referrer
     *
     * @param string $templatePath Template path
     *
     * @return string found template path
     */
    public function locateTemplate($templatePath)
    {
        return $this
            ->container
            ->get('elcodi_store.template_locator.core')
            ->locate($templatePath);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'template_locator_extension';
    }
}
