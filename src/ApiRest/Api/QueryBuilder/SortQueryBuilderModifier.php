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
 
namespace ApiRest\Api\QueryBuilder;
use ApiRest\Api\Event\QueryBuilderEvent;

/**
 * Class SortQueryBuilderModifier
 */
class SortQueryBuilderModifier implements QueryBuilderModifier
{
    /**
     * Modify query builder
     *
     * @param QueryBuilderEvent $event Event
     */
    public function modify(QueryBuilderEvent $event)
    {
        $queryBuilder = $event->getQueryBuilder();

        $sortElements = $event
            ->getApiRestEvent()
            ->getRequest()
            ->query
            ->get('sort');

        $sortArray = explode(',', $sortElements);
        foreach ($sortArray as $sortElement) {
            $cleanSortElement = ltrim($sortElement, '-');
            $direction = ($sortElement === $cleanSortElement)
                ? 'ASC'
                : 'DESC';

            $queryBuilder->orderBy('x.' . $cleanSortElement, $direction);
        }
    }
}
