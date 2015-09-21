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

namespace ApiRest\Api\Loader;

use ApiRest\Api\Event\ApiRestEvent;
use ApiRest\Api\Loader\Abstracts\AbstractEntityLoader;

/**
 * Class EntityBulkLoader
 */
class EntityBulkLoader extends AbstractEntityLoader implements Loader
{
    /**
     * Load the data
     *
     * @param ApiRestEvent $event Event
     */
    public function load(ApiRestEvent $event)
    {
        $entityConfiguration = $event->getEntityConfiguration();
        $entityNamespace = $event->getEntityNamespace();

        $queryBuilder = $this
            ->repositoryProvider
            ->getRepositoryByEntityNamespace($entityNamespace)
            ->createQueryBuilder('x');

        $this
            ->eventDispatcher
            ->createQueryBuilderEvent(
                $event,
                $queryBuilder
            );

        $entities = $queryBuilder
            ->getQuery()
            ->getResult();

        $data = [];
        foreach ($entities as $entity) {
            $data[] = $this
                ->loadEntity(
                    $entityConfiguration,
                    $entity
                );
        }

        $event->addResponseData($data);
    }
}
