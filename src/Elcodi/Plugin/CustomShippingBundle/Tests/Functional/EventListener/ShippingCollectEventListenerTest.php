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

namespace Elcodi\Plugin\CustomShippingBundle\Tests\Functional\Provider;

use Symfony\Component\Console\Input\ArrayInput;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class ShippingCollectEventListenerTest
 */
class ShippingCollectEventListenerTest extends WebTestCase
{
    /**
     * Schema must be loaded in all test cases
     *
     * @return boolean Load schema
     */
    protected function loadSchema()
    {
        return true;
    }

    /**
     * load fixtures method
     *
     * This method is only called if create Schema is set to true
     *
     * Only load fixtures if loadFixtures() is set to true.
     * All other methods will be loaded if this one is loaded.
     *
     * Otherwise, will return.
     *
     * @return $this Self object
     */
    protected function loadFixtures()
    {
        parent::loadFixtures();

        self::$application->run(new ArrayInput([
            'command'          => 'elcodi:plugins:load',
            '--no-interaction' => true,
            '--quiet'          => true,
        ]));
    }

    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return ['elcodi_plugin.custom_shipping.event_listener.shipping_collect'];
    }
}
