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
 * Class StoreUnderConstructionEventListener
 */
class StoreUnderConstructionEventListener extends AbstractStoreEventListener
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
     * Store is under construction
     */
    protected $storeIsUnderConstruction;

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
     * @param EngineInterface $twig                     Twig
     * @param string          $templateBundle           Template bundle
     * @param boolean         $storeIsUnderConstruction Store is under construction
     * @param string          $adminPrefix              Admin prefix
     */
    public function __construct(
        EngineInterface $twig,
        $templateBundle,
        $storeIsUnderConstruction,
        $adminPrefix
    ) {
        $this->twig = $twig;
        $this->templateBundle = $templateBundle;
        $this->storeIsUnderConstruction = $storeIsUnderConstruction;
        $this->adminPrefix = $adminPrefix;
    }

    /**
     * Check if store is enabled
     *
     * @param GetResponseEvent $event Event
     *
     * @return Response
     */
    public function checkIfStoreIsUnderConstruction(GetResponseEvent $event)
    {
        $inStore = $this
            ->inStore(
                $event->getRequest(),
                $this->adminPrefix
            );

        if ($inStore && $this->storeIsUnderConstruction) {
            $data = $this
                ->twig
                ->render($this->templateBundle.':Pages:store-under-construction.html.twig');

            $event->setResponse(new Response($data));
        }
    }
}
