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
 
namespace ApiRest\Api\Decorator;

use ApiRest\Api\Event\ApiRestEvent;

/**
 * Class MetaDecorator
 */
class MetaDecorator implements Decorator
{
    /**
     * @var mixed
     *
     * Meta
     */
    private $meta;

    /**
     * Construct
     *
     * @param mixed $meta Meta
     */
    public function __construct($meta)
    {
        $this->meta = $meta;
    }

    /**
     * Decorates the event
     *
     * @param ApiRestEvent $event Event
     */
    public function decorate(ApiRestEvent $event)
    {
        if (is_array($this->meta) && !empty($this->meta)) {
            $event->addResponseMeta($this->meta);
        }
    }
}
