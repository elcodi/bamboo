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
 
namespace Elcodi\Plugin\TemplateConverterBundle\Adapter\Loader\ValueObject;

/**
 * Class FileCollector
 */
class FileCollector
{
    /**
     * @var File[]
     *
     * File collection
     */
    private $files = [];

    /**
     * Add file
     *
     * @param File $file File
     */
    public function addFile(File $file)
    {
        $this->files[$file->getFilename()] = $file;
    }

    /**
     * Get file by filename
     *
     * @param string $filename Filename
     *
     * @return File|null File found
     */
    public function getFileByName($filename)
    {
        return isset($this->files[$filename])
            ? $this->files[$filename]
            : null;
    }
}
