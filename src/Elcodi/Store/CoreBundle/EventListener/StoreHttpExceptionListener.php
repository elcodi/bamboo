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

namespace Elcodi\Store\CoreBundle\EventListener;

use Exception;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
     * @var string[]
     *
     * Template path by status code for rendering
     */
    protected $templates;

    /**
     * Constructor
     *
     * @param EngineInterface $templating      Template engine
     * @param TemplateLocator $templateLocator Where to search for templates
     * @param string[]        $templates       Template path by status code
     */
    public function __construct(
        EngineInterface $templating,
        TemplateLocator $templateLocator,
        array           $templates
    ) {
        $this->templating = $templating;
        $this->templateLocator = $templateLocator;
        $this->templates = $templates;
    }

    /**
     * Generate a generic response for non-http exceptions
     *
     * @param FlattenException $exception
     *
     * @return Response
     */
    public function showExceptionAction(FlattenException $exception)
    {
        return $this->createResponse(
            $exception,
            $exception->getStatusCode(),
            $exception->getMessage()
        );
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if (!$this->supports($event)) {
            return;
        }

        $this->isHandlingException = true;

        /**
         * @var $exception HttpException
         */
        $exception = $event->getException();

        $response = $this->createResponse(
            $exception,
            $exception->getStatusCode(),
            $exception->getMessage()
        );

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

        $exception = $event->getException();
        if (!$exception instanceof HttpExceptionInterface) {
            return false;
        }

        return array_key_exists($exception->getStatusCode(), $this->templates);
    }

    /**
     * Generates a response for a status code error
     *
     * @param Exception|FlattenException $exception
     * @param integer                    $statusCode
     * @param string                     $message
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

        $template = $this->locateTemplateByStatusCode($statusCode);
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
    protected function locateTemplateByStatusCode($statusCode)
    {
        return $this
            ->templateLocator
            ->locate(
                $this->templates[$statusCode]
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
