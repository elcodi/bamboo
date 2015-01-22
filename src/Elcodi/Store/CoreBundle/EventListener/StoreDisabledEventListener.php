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
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Templating\EngineInterface;

use Elcodi\Store\CoreBundle\EventListener\Abstracts\AbstractStoreEventListener;

/**
 * Class StoreDisabledEventListener
 */
class StoreDisabledEventListener extends AbstractStoreEventListener
{
    /**
     * @var EngineInterface
     *
     * Twig
     */
    protected $twig;

    /**
     * @var boolean
     *
     * Store is enabled
     */
    protected $storeIsEnabled;

    /**
     * @var string
     *
     * Template bundle
     */
    protected $templateBundle;

    /**
     * @var string
     *
     * Admin prefix
     */
    protected $adminPrefix;

    /**
     * Constructor
     *
     * @param EngineInterface $twig           Twig
     * @param string          $templateBundle Template bundle
     * @param boolean         $storeIsEnabled Store is enabled
     * @param string          $adminPrefix    Admin prefix
     */
    public function __construct(
        EngineInterface $twig,
        $templateBundle,
        $storeIsEnabled,
        $adminPrefix
    )
    {
        $this->twig = $twig;
        $this->templateBundle = $templateBundle;
        $this->storeIsEnabled = $storeIsEnabled;
        $this->adminPrefix = $adminPrefix;
    }

    /**
     * Check if store is disabled
     *
     * @param GetResponseEvent $event Event
     *
     * @return Response
     */
    public function checkIfStoreIsDisabled(GetResponseEvent $event)
    {
        $inStore = $this
            ->inStore(
                $event->getRequest(),
                $this->adminPrefix
            );

        if ($inStore && !$this->storeIsEnabled) {

            $data = $this
                ->twig
                ->render($this->templateBundle . ':Pages:store-disabled.html.twig');

            $event->setResponse(new Response($data));
        }
    }
}
