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

namespace Elcodi\Common\ConfigurationBundle\Tests\FakeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Fake Controller object
 */
class FakeController extends Controller
{
    /**
     * Get parameter from Configuration
     *
     * @\Elcodi\Common\ConfigurationBundle\Annotation\Configuration(
     *      name = "parameter",
     *      key  = "settings.parameter",
     * )
     *
     * @\Mmoreram\ControllerExtraBundle\Annotation\JsonResponse()
     *
     * @param $parameter
     *
     * @return array
     */
    public function parameterAction($parameter)
    {
        return [
            'parameter' => $parameter,
        ];
    }

    /**
     * Get parameter from Configuration with default value
     *
     * @\Elcodi\Common\ConfigurationBundle\Annotation\Configuration(
     *      name    = "parameterWithDefault",
     *      key     = "settings.parameter",
     *      default = 20,
     * )
     *
     * @\Mmoreram\ControllerExtraBundle\Annotation\JsonResponse()
     *
     * @param $parameterWithDefault
     *
     * @return array
     */
    public function parameterWithDefaultAction($parameterWithDefault)
    {
        return [
            'parameter' => $parameterWithDefault,
        ];
    }

    /**
     * Get non-existent parameter from Configuration
     *
     * @\Elcodi\Common\ConfigurationBundle\Annotation\Configuration(
     *      name = "parameterWithDefault",
     *      key  = "settings.non_existent_parameter",
     * )
     *
     * @\Mmoreram\ControllerExtraBundle\Annotation\JsonResponse()
     *
     * @param $nonExistentParameter
     *
     * @return array
     */
    public function nonExistentParameterAction($nonExistentParameter)
    {
        return [
            'parameter' => $nonExistentParameter,
        ];
    }

    /**
     * Get non-existent parameter from Configuration with default value
     *
     * @\Elcodi\Common\ConfigurationBundle\Annotation\Configuration(
     *      name    = "parameterWithDefault",
     *      key     = "settings.non_existent_parameter",
     *      default = 30,
     * )
     *
     * @\Mmoreram\ControllerExtraBundle\Annotation\JsonResponse()
     *
     * @param $parameterWithDefault
     *
     * @return array
     */
    public function nonExistentParameterWithDefaultAction($parameterWithDefault)
    {
        return [
            'parameter' => $parameterWithDefault,
        ];
    }
}
