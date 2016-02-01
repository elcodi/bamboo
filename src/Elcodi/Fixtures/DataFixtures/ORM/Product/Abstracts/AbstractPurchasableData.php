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

namespace Elcodi\Fixtures\DataFixtures\ORM\Product\Abstracts;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Bundle\MediaBundle\DataFixtures\ORM\Traits\ImageManagerTrait;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;

/**
 * Class AbstractPurchasableData
 */
abstract class AbstractPurchasableData extends AbstractFixture
{
    use ImageManagerTrait;

    /**
     * Steps necessary to store an image
     *
     * @param PurchasableInterface $purchasable Purchasable
     * @param string               $imageName   Image name
     *
     * @return $this Self object
     */
    protected function storePurchasableImage(
        PurchasableInterface $purchasable,
        $imageName
    ) {
        $imagePath = realpath(__DIR__ . '/../images/' . $imageName);
        $image = $this->storeImage($imagePath);

        $purchasable->addImage($image);
        $purchasable->setPrincipalImage($image);

        return $this;
    }
}
