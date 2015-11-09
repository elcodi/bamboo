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
 
namespace Elcodi\Plugin\TemplateConverterBundle\Adapter\Loader;

use Elcodi\Plugin\TemplateConverterBundle\Adapter\Loader\Abstracts\AbstractProjectLoader;
use Elcodi\Plugin\TemplateConverterBundle\Exception\AdapterNotFoundException;

/**
 * Class LoaderFactory
 */
class LoaderFactory
{
    /**
     * Create loader given the adapter name
     *
     * @param string $adapterName Adapter name
     *
     * @return AbstractProjectLoader Adapter
     *
     * @throws AdapterNotFoundException Adapter not found
     */
    public function createLoaderByAdapterName($adapterName)
    {
        $adapterName = strtolower($adapterName);
        $adapterName = ucfirst($adapterName);
        $adapterNamespace = __NAMESPACE__ . '\\' . $adapterName;

        if (!class_exists($adapterNamespace)) {

            throw new AdapterNotFoundException();
        }

        return new $adapterNamespace;
    }
}
