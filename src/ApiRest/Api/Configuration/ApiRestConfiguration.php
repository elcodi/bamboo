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

namespace ApiRest\Api\Configuration;

/**
 * Class ApiRestConfiguration
 */
class ApiRestConfiguration
{
    /**
     * @var boolean
     *
     * enabled
     */
    private $enabled;

    /**
     * @var string
     *
     * Entity alias
     */
    private $entityAlias;

    /**
     * @var string
     *
     * Entity namespace
     */
    private $entityNamespace;

    /**
     * @var integer
     *
     * Api level
     */
    private $apiLevel;

    /**
     * Construct
     *
     * @param boolean $enabled         Enabled
     * @param string  $entityAlias     Entity alias
     * @param string  $entityNamespace Entity namespace
     * @param integer $apiLevel        Api level
     */
    public function __construct(
        $enabled,
        $entityAlias,
        $entityNamespace,
        $apiLevel
    )
    {
        $this->enabled = $enabled;
        $this->entityAlias = $entityAlias;
        $this->entityNamespace = $entityNamespace;
        $this->apiLevel = $apiLevel;
    }

    /**
     * Get Enabled
     *
     * @return boolean Enabled
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Get EntityAlias
     *
     * @return string EntityAlias
     */
    public function getEntityAlias()
    {
        return $this->entityAlias;
    }

    /**
     * Get EntityNamespace
     *
     * @return string EntityNamespace
     */
    public function getEntityNamespace()
    {
        return $this->entityNamespace;
    }

    /**
     * Get ApiLevel
     *
     * @return int ApiLevel
     */
    public function getApiLevel()
    {
        return $this->apiLevel;
    }
}
