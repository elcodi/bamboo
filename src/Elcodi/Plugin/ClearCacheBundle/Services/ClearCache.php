<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Maksim <kodermax@gmail.com>
 */

namespace Elcodi\Plugin\ClearCacheBundle\Services;

/**
 * Class ClearCache
 * @package Elcodi\Plugin\ClearCacheBundle\Services
 */
class ClearCache
{
    /**
     * @var string
     *
     * Cache path
     */
    protected $cachePath;

    /**
     * ClearCache constructor.
     * @param $cachePath CachePath
     */
    public function __construct($cachePath)
    {
        $this->cachePath = $cachePath;
    }

    /**
     * Return Size Of Directory
     * @param $dir - path
     * @return int - bytes
     */
    private function getDirSize($dir)
    {
        if (!file_exists($dir)) {
            return 0;
        }
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir), \RecursiveIteratorIterator::SELF_FIRST);
        $size = 0;
        foreach ($iterator as $path) {
            if (!$path->isDir()) {
                $size += $path->getSize();
            }
        }

        return $size;
    }

    /**
     * Return an array of cache sizes
     * @return mixed
     */
    public function getSizes()
    {
        $arResult['cache_annotations'] = $this->getDirSize($this->cachePath . '/annotations');
        $arResult['cache_doctrine'] = $this->getDirSize($this->cachePath . '/doctrine');
        $arResult['cache_translations'] = $this->getDirSize($this->cachePath . '/translations');
        $arResult['cache_profiler'] = $this->getDirSize($this->cachePath . '/profiler');
        $arResult['cache_twig'] = $this->getDirSize($this->cachePath . '/twig');

        return $arResult;
    }

    /**
     * Remove directory
     * @param $path Path
     */
    private function deleteDir($path)
    {
        $files = glob($path . '/*');

        foreach ($files as $file) {
            is_dir($file)
                ? $this->deleteDir($file)
                : unlink($file);
        }
        rmdir($path);
    }

    /**
     * Delete all Cache
     */
    public function deleteCache()
    {
        $this->deleteDir($this->cachePath . '/annotations');
        $this->deleteDir($this->cachePath . '/doctrine');
        $this->deleteDir($this->cachePath . '/translations');
        $this->deleteDir($this->cachePath . '/profiler');
        $this->deleteDir($this->cachePath . '/twig');
    }
}
