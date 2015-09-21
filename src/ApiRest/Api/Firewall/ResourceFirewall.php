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

namespace ApiRest\Api\Firewall;

use ApiRest\Api\Configuration\ApiRestConfiguration;
use ApiRest\Api\Event\ApiRestEvent;
use Elcodi\Component\Core\Services\RepositoryProvider;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class ResourceFirewall
 */
final class ResourceFirewall implements Firewall
{
    /**
     * @var RepositoryProvider
     *
     * Repository provider
     */
    protected $repositoryProvider;

    /**
     * Constructor
     *
     * @param RepositoryProvider $repositoryProvider Repository provider
     */
    function __construct(RepositoryProvider $repositoryProvider)
    {
        $this->repositoryProvider = $repositoryProvider;
    }

    /**
     * Check route validity
     *
     * @param ApiRestEvent $event Event
     */
    public function filter(ApiRestEvent $event)
    {
        $entityNamespace = $event->getEntityNamespace();
        $entityId = $event->getEntityId();
        $entityConfiguration = $event->getEntityConfiguration();

        if (!$entityConfiguration instanceof ApiRestConfiguration) {

            $event->resolveWithResourceNotFound();

            return;
        }

        $entity = $this
            ->repositoryProvider
            ->getRepositoryByEntityNamespace($entityNamespace)
            ->find($entityId);

        if (!$entity instanceof $entityNamespace) {

            $event->resolveWithResourceNotFound();

            return;
        }
    }
}
