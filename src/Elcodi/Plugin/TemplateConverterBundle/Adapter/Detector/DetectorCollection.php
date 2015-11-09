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
 * Class DetectorCollection
 */
class DetectorCollection
{
    /**
     * @var DetectorInterface[]
     *
     * Detectors
     */
    private $detectors = [];

    /**
     * Add detector
     *
     * @param DetectorInterface $detector Detector
     */
    public function addDetector(DetectorInterface $detector)
    {
        $this->detectors[] = $detector;
    }

    /**
     * Get valid detector for a project path
     *
     * @param string $projectPath Project path
     *
     * @return DetectorInterface|null Valid detector
     */
    public function getValidDetectorByProjectPath($projectPath)
    {
        foreach ($this->detectors as $detector) {

            if ($detector->matches($projectPath)) {

                return $detector;
            }
        }

        return null;
    }
}
