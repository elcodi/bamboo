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

namespace Elcodi\Admin\PluginBundle;

use Symfony\Component\Console\Application;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use Elcodi\Admin\PluginBundle\DependencyInjection\AdminPluginExtension;

/**
 * Class AdminPluginBundle
 */
class AdminPluginBundle extends Bundle
{
    /**
     * Returns the bundle's container extension.
     *
     * @return AdminPluginExtension
     */
    public function getContainerExtension()
    {
        return new AdminPluginExtension();
    }

    /**
     * Register Commands.
     *
     * Disabled as commands are registered as services.
     *
     * @param Application $application An Application instance
     *
     * @return null
     */
    public function registerCommands(Application $application)
    {
        return null;
    }
}
