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

namespace Elcodi\Store\CoreBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class StorePageNotFoundListener
 */
class StorePageNotFoundListener
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
     * @var string
     *
     * Template path for rendering
     */
    protected $template;

    /**
     * Constructor
     *
     * @param EngineInterface $templating template engine
     * @param string          $template   template path
     */
    public function __construct(EngineInterface $templating, $template)
    {
        $this->templating = $templating;
        $this->template = $template;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if (!$this->supports($event)) {
            return;
        }

        /**
         * @var $exception HttpException
         */
        $exception = $event->getException();
        $statusCode = $exception->getStatusCode();
        $statusText = $exception->getMessage();

        $this->isHandlingException = true;

        $content = $this->renderContent([
            'exception' => $exception,
            'status_code' => $statusCode,
            'status_text' => $statusText,
        ]);
        $response = new Response($content, $statusCode);
        $event->setResponse($response);

        $this->isHandlingException = false;
    }

    /**
     * Renders the content of the error page
     *
     * @param array $context
     *
     * @return string
     */
    protected function renderContent(array $context)
    {
        return $this->templating->render($this->template, $context);
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

        return $exception->getStatusCode() == 404;
    }
}
