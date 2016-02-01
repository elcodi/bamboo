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

namespace Elcodi\Plugin\StoreTemplateBundle;

use Elcodi\Bundle\CoreBundle\Abstracts\AbstractElcodiBundle;
use Elcodi\Component\Plugin\Interfaces\PluginInterface;

/**
 * Class StoreTemplateBundle
 */
class StoreTemplateBundle extends AbstractElcodiBundle implements PluginInterface
{
    /**
     * Returns the bundle's container extension.
     *
     * @return null
     */
    public function getContainerExtension()
    {
        return null;
    }
}
