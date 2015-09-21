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
 
namespace ApiRest\Api\Event;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class QueryBuilderEvent
 */
final class QueryBuilderEvent extends Event
{
    /**
     * @var ApiRestEvent
     *
     * ApiRest Event
     */
    private $apiRestEvent;

    /**
     * @var QueryBuilder
     *
     * Query builder
     */
    private $queryBuilder;

    /**
     * Constructor
     *
     * @param ApiRestEvent $apiRestEvent
     * @param QueryBuilder $queryBuilder
     */
    public function __construct(
        ApiRestEvent $apiRestEvent,
        QueryBuilder $queryBuilder
    )
    {
        $this->apiRestEvent = $apiRestEvent;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * Get ApiRestEvent
     *
     * @return ApiRestEvent ApiRestEvent
     */
    public function getApiRestEvent()
    {
        return $this->apiRestEvent;
    }

    /**
     * Get QueryBuilder
     *
     * @return mixed QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }
}
