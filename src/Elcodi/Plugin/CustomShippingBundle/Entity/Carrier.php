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

namespace Elcodi\Plugin\CustomShippingBundle\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Tax\Entity\Interfaces\TaxInterface;
use Elcodi\Plugin\CustomShippingBundle\Entity\Interfaces\CarrierInterface;

/**
 * Class Carrier
 */
class Carrier implements CarrierInterface
{
    use IdentifiableTrait, EnabledTrait;

    /**
     * @var string
     *
     * name
     */
    protected $name;

    /**
     * @var string
     *
     * description
     */
    protected $description;

    /**
     * @var Collection
     *
     * ranges
     */
    protected $ranges;

    /**
     * @var TaxInterface
     *
     * Tax
     */
    protected $tax;

    /**
     * Get Description
     *
     * @return string Description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets Description
     *
     * @param string $description Description
     *
     * @return $this Self object
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Ranges
     *
     * @return Collection Ranges
     */
    public function getRanges()
    {
        return $this->ranges;
    }

    /**
     * Sets Ranges
     *
     * @param Collection $ranges Ranges
     *
     * @return $this Self object
     */
    public function setRanges($ranges)
    {
        $this->ranges = $ranges;

        return $this;
    }

    /**
     * Get Tax
     *
     * @return TaxInterface Tax
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Sets Tax
     *
     * @param TaxInterface $tax Tax
     *
     * @return $this Self object
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }
}
