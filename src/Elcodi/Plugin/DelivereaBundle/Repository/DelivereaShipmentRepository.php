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

namespace Elcodi\Plugin\DelivereaBundle\Repository;

use Doctrine\ORM\EntityRepository;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Plugin\DelivereaBundle\DelivereaTrackingCodes;
use Elcodi\Plugin\DelivereaBundle\Entity\DelivereaShipment;

/**
 * Class DelivereaShipmentRepository
 */
class DelivereaShipmentRepository extends EntityRepository
{
    /**
     * Gets the deliverea shipment for the given order.
     *
     * @param OrderInterface $order The order received.
     *
     * @return null|DelivereaShipment
     */
    public function getDelivereaShipment(OrderInterface $order)
    {
        $query = $this
            ->createQueryBuilder('d')
            ->where('d.order = :order')
            ->setParameter('order', $order)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * Gets the shipments that still have actions pending
     *
     * @return array
     */
    public function getShipmentsWithActionsPending()
    {
        $queryBuilder = $this->createQueryBuilder('d');
        $query = $queryBuilder
            ->select('d')
            ->join('d.order', 'o')
            ->join('o.shippingLastStateLine', 's')
            ->where(
                $queryBuilder
                    ->expr()
                    ->notIn(
                        's.name',
                        [
                            'delivered',
                            'cancelled',
                            'returned',
                        ]
                    )
            )
            ->getQuery();

        return $query->getResult();
    }
}
