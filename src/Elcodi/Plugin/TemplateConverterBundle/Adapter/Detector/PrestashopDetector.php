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
 
namespace Elcodi\Plugin\TemplateConverterBundle\Adapter\Detector;
use Elcodi\Plugin\TemplateConverterBundle\Adapter\Detector\Interfaces\DetectorInterface;

/**
 * Class PrestashopDetector
 */
class PrestashopDetector implements DetectorInterface
{
    /**
     * This type matches a project
     *
     * @param string $projectPath Project path
     *
     * @return boolean matches given project
     */
    public function matches($projectPath)
    {
        $projectPath = realpath($projectPath);
        $projectPath = rtrim($projectPath, '/') . '/';

        return
            file_exists($projectPath . 'layout.tpl') &&
            file_exists($projectPath . 'password.tpl') &&
            file_exists($projectPath . 'search.tpl');
    }

    /**
     * Get adapter name
     *
     * @return string Adapter name
     */
    public function getAdapterName()
    {
        return 'Prestashop';
    }

    /**
     * Get engine name
     *
     * @return string Engine name
     */
    public function getEngineName()
    {
        return 'Smarty3';
    }
}
