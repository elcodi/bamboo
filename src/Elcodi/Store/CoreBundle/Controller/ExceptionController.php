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

namespace Elcodi\Store\CoreBundle\Controller;

use Symfony\Bundle\TwigBundle\Controller\ExceptionController as BaseExceptionController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\TemplateReferenceInterface;
use Twig_Environment;

use Elcodi\Store\CoreBundle\Services\TemplateLocator;

/**
 * Class ExceptionController
 */
class ExceptionController extends BaseExceptionController
{
    /**
     * @var TemplateLocator
     *
     * Template locator
     */
    protected $templateLocator;

    /**
     * @var string
     *
     * Template by default
     */
    protected $defaultTemplate;

    /**
     * @var string[]
     *
     * Template path by status code for rendering
     */
    protected $templateByCode;

    /**
     * @var integer|null
     *
     * Status code for non http-exceptions, or null for no fallback
     */
    protected $fallbackCode;

    /**
     * Constructor
     *
     * @param Twig_Environment $twig            Template engine
     * @param bool             $debug           Show error (false) or exception (true) pages by default
     * @param TemplateLocator  $templateLocator Where to search for templates
     * @param string           $defaultTemplate Default template
     * @param string[]         $templateByCode  Template by status code
     * @param integer|null     $fallbackCode    Status code for fallback exceptions
     */
    public function __construct(
        Twig_Environment $twig,
        $debug,
        TemplateLocator $templateLocator,
        $defaultTemplate,
        array $templateByCode,
        $fallbackCode = null
    ) {
        parent::__construct($twig, $debug);

        $this->templateLocator = $templateLocator;
        $this->defaultTemplate = $defaultTemplate;
        $this->templateByCode  = $templateByCode;
        $this->fallbackCode    = $fallbackCode;
    }

    /**
     * Checks if we can process the current event
     *
     * @param Request $request
     *
     * @return bool
     */
    protected function supports(Request $request)
    {
        return $request->getRequestFormat() === 'html' && $this->fallbackCode;
    }

    /**
     * Return the template for rendering a status code
     *
     * @param Request $request
     * @param string  $format
     * @param integer $code          Status code to locate a template
     * @param bool    $showException
     *
     * @return TemplateReferenceInterface
     */
    protected function findTemplate(Request $request, $format, $code, $showException)
    {
        if (!$this->supports($request)) {
            return parent::findTemplate($request, $format, $code, $showException);
        }

        return $this
            ->templateLocator
            ->locate(
                isset($this->templateByCode[$code])
                    ? $this->templateByCode[$code]
                    : $this->defaultTemplate
            );
    }
}
