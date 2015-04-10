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

namespace Elcodi\Common\ConfigurationBundle\Tests\Functional;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class ConfigurationTest
 */
class ConfigurationTest extends WebTestCase
{
    /**
     * Check for existing parameter
     */
    public function testExistingParameter()
    {
        $client = static::createClient();

        $client->request('GET', '/fake/parameter');

        $this->assertEquals(
            '{"parameter":10}',
            $client
                ->getResponse()
                ->getContent()
        );
    }

    /**
     * Default value is not used if parameter exists
     */
    public function testExistingParameterWithDefault()
    {
        $client = static::createClient();

        $client->request('GET', '/fake/parameter_with_default');

        $this->assertEquals(
            '{"parameter":10}',
            $client
                ->getResponse()
                ->getContent()
        );
    }

    /**
     * Throw if parameter does not exist
     *
     * @expectedException \Elcodi\Component\Configuration\Exception\ConfigurationParameterNotFoundException
     */
    public function testNonExistingParameter()
    {
        $client = static::createClient();

        $client->request('GET', '/fake/parameter_non_existent');
    }

    /**
     * If parameter does not exist and a default is provided, use default
     */
    public function testNonExistingParameterWithDefault()
    {
        $client = static::createClient();

        $client->request('GET', '/fake/parameter_non_existent_with_default');

        $this->assertEquals(
            '{"parameter":30}',
            $client
                ->getResponse()
                ->getContent()
        );
    }
}
