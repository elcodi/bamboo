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

namespace Elcodi\Plugin\DelivereaBundle\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Plugin\DelivereaBundle\Entity\DelivereaShipment;

/**
 * Class DelivereaShippingFactory
 */
class DelivereaShippingFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance
     *
     * @return DelivereaShipment Empty entity
     */
    public function create()
    {
        /**
         * @var DelivereaShipment $delivereaShipment
         */
        $classNamespace = $this->getEntityNamespace();
        $delivereaShipment = new $classNamespace();
        $delivereaShipment->setCreatedAt(new \DateTime());
        $delivereaShipment->setUpdatedAt(new \DateTime());

        return $delivereaShipment;
    }
}
