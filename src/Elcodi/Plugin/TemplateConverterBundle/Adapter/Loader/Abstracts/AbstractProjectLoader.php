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

namespace Elcodi\Plugin\TemplateConverterBundle\Adapter\Loader\Abstracts;

use Elcodi\Plugin\TemplateConverterBundle\Adapter\Loader\ValueObject\File;
use Elcodi\Plugin\TemplateConverterBundle\Adapter\Loader\ValueObject\FileCollector;
use Symfony\Component\Finder\Finder;

/**
 * Abstract class AbstractProjectLoader
 */
abstract class AbstractProjectLoader
{
    /**
     * Get the project skeleton. The result must be like follows
     *
     * [
     *      "file1.tpl",
     *      "file2.txt",
     *      "folder/*.tpl",
     *      ...
     * ]
     */
    abstract protected function getProjectSkeleton();

    /**
     * Load the project
     *
     * @param string $projectPath Project path
     *
     * @return FileCollector File collector loaded
     */
    public function loadProject($projectPath)
    {
        $projectPath = realpath($projectPath);
        $projectPath = rtrim($projectPath, '/') . '/';
        $finder = new Finder();
        $finder->files();

        foreach ($this->getProjectSkeleton() as $entry) {
            $absoluteEntry = $projectPath . ltrim($entry, '/');
            $finder->in($absoluteEntry);
        }

        $fileCollector = new FileCollector();
        foreach ($finder as $file) {

            $fileCollector->addFile(
                new File(
                    str_replace($projectPath, '', $file->getRealPath()),
                    file_get_contents($file->getRealPath())
                )
            );
        }

        return $fileCollector;
    }
}
