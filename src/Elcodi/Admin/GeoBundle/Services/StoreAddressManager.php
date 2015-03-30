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

namespace Elcodi\Admin\GeoBundle\Services;

use Elcodi\Component\Configuration\Services\ConfigurationManager;
use Elcodi\Component\Geo\Entity\Address;
use Elcodi\Component\Geo\Repository\AddressRepository;

/**
 * Class StoreAddressManager
 */
class StoreAddressManager
{
    /**
     * @var ConfigurationManager
     *
     * A configuration manager
     */
    protected $configurationManager;

    /**
     * @var AddressRepository
     *
     * An address repository
     */
    protected $addressRepository;

    /**
     * Builds a new store address manager
     *
     * @param ConfigurationManager $configurationManager A configuration manager
     * @param AddressRepository    $addressRepository    An address repository
     */
    public function __construct(
        ConfigurationManager $configurationManager,
        AddressRepository $addressRepository
    ) {
        $this->configurationManager = $configurationManager;
        $this->addressRepository    = $addressRepository;
    }

    /**
     * Gets the store address.
     *
     * @return null|Address
     * @throws \Exception
     */
    public function getStoreAddress()
    {
        $storeAddressId =
            $this
                ->configurationManager
                ->get('store.address');

        $address = null;
        if (!empty($storeAddressId)) {
            $address = $this
                ->addressRepository
                ->findOneBy(['id' => $storeAddressId]);
        }

        return $address;
    }

    /**
     * Sets a store address.
     *
     * @param Address $address The address to set
     */
    public function setStoreAddress(Address $address)
    {
        $this
            ->configurationManager
            ->set('store.address', $address->getId());
    }
}
