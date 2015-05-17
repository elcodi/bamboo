<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Store\CoreBundle\EventListener;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Templating\EngineInterface;

use Elcodi\Store\CoreBundle\Services\TemplateLocator;

/**
 * Class StoreHttpExceptionListener
 */
class StoreHttpExceptionListener
{
    /**
     * @var bool
     *
     * Helps avoiding endless loops when the rendering throws
     */
    protected $isHandlingException = false;

    /**
     * @var EngineInterface
     *
     * Template engine
     */
    protected $templating;

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
     * @param EngineInterface $templating      Template engine
     * @param TemplateLocator $templateLocator Where to search for templates
     * @param string          $defaultTemplate Default template
     * @param string[]        $templateByCode  Template by status code
     * @param integer|null    $fallbackCode    Status code for fallback exceptions
     */
    public function __construct(
        EngineInterface $templating,
        TemplateLocator $templateLocator,
                        $defaultTemplate,
        array           $templateByCode,
                        $fallbackCode = null
    ) {
        $this->templating      = $templating;
        $this->templateLocator = $templateLocator;
        $this->defaultTemplate = $defaultTemplate;
        $this->templateByCode  = $templateByCode;
        $this->fallbackCode    = $fallbackCode;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if (!$this->supports($event)) {
            return null;
        }

        $this->isHandlingException = true;

        $exception = $event->getException();

        $statusCode = $exception instanceof HttpExceptionInterface
            ? $exception->getStatusCode()
            : $this->fallbackCode;

        $message = $exception->getMessage();

        $response = $this->createResponse($exception, $statusCode, $message);

        $event->setResponse($response);

        $this->isHandlingException = false;
    }

    /**
     * Checks if we can process the current event
     *
     * @param $event
     *
     * @return bool
     */
    protected function supports(GetResponseForExceptionEvent $event)
    {
        if (!$event->isMasterRequest() || $this->isHandlingException) {
            return false;
        }

        if ($event->getRequest()->getRequestFormat() !== 'html') {
            return false;
        }

        if ($this->fallbackCode) {
            return true;
        }

        return $event->getException() instanceof HttpExceptionInterface;
    }

    /**
     * Generates a response for a status code error
     *
     * @param Exception $exception  Exception
     * @param integer   $statusCode Status code
     * @param string    $message    Exception message
     *
     * @return Response
     */
    protected function createResponse($exception, $statusCode, $message)
    {
        $context = [
            'exception' => $exception,
            'status_code' => $statusCode,
            'status_text' => $message,
        ];

        $template = $this->locateTemplateByCode($statusCode);
        $content = $this->renderTemplate($template, $context);

        return new Response($content, $statusCode);
    }

    /**
     * Return the template for rendering a status code
     *
     * @param integer $statusCode Status code to locate a template
     *
     * @return string
     */
    protected function locateTemplateByCode($statusCode)
    {
        return $this
            ->templateLocator
            ->locate(
                isset($this->templateByCode[$statusCode])
                    ? $this->templateByCode[$statusCode]
                    : $this->defaultTemplate
            );
    }

    /**
     * Renders the content of the error page
     *
     * @param string $template Template to render
     * @param array  $context  Context to pass to the engine
     *
     * @return string
     */
    protected function renderTemplate($template, array $context)
    {
        return $this
            ->templating
            ->render($template, $context);
    }
}
