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

namespace Elcodi\Admin\CoreBundle\Controller\Abstracts;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class AbstractStatsController
 */
abstract class AbstractStatsController extends Controller
{
    /**
     * return number of entity instances from the begining
     *
     * @param string $entity Entity namespace parameter
     *
     * @return integer Total of instances
     */
    protected function getTotalStats($entity)
    {
        return $this->getTotalsByInterval($entity);
    }

    /**
     * return number of entity instances from the begining of the month
     *
     * @param string $entity Entity namespace parameter
     *
     * @return integer Total of monthly instances
     */
    protected function getMonthlyStats($entity)
    {
        return $this->getTotalsByInterval(
            $entity,
            new DateTime('midnight first day of this month'),
            new DateTime()
        );
    }

    /**
     * return number of entity instances from today
     *
     * @param string $entity Entity namespace parameter
     *
     * @return integer Total of today instances
     */
    protected function getDailyStats($entity)
    {
        return $this->getTotalsByInterval(
            $entity,
            new DateTime('today midnight'),
            new DateTime()
        );
    }

    /**
     * Get total elements of certain entity, given an interval
     *
     * @param string   $entity Entity class parameter
     * @param DateTime $from   From
     * @param DateTime $to     To
     *
     * @return array
     */
    protected function getTotalsByInterval(
        $entity,
        DateTime $from = null,
        DateTime $to = null
    ) {
        $namespace = $this
            ->container
            ->getParameter($entity);

        $queryBuilder = $this
            ->get('elcodi.provider.manager')
            ->getManagerByEntityNamespace($namespace)
            ->createQueryBuilder()
            ->select('count(x.id)')
            ->from($namespace, 'x');

        if (is_null($to)) {
            $to = new DateTime();
        }

        if (!is_null($from)) {
            $queryBuilder
                ->andWhere('x.createdAt >= ?1')
                ->andWhere('x.createdAt <= ?2')
                ->setParameters([
                    1 => $from,
                    2 => $to,
                ]);
        }

        return $queryBuilder
            ->getQuery()
            ->getSingleScalarResult();
    }
}
