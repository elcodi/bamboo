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

namespace ApiRest\Api\Cleaner;

use ApiRest\Api\Event\ApiRestEvent;

/**
 * Class EmptyElementsCleaner
 */
class EmptyElementsCleaner implements Cleaner
{
    /**
     * Cleans the response
     *
     * @param ApiRestEvent $event Event
     */
    public function clean(ApiRestEvent $event)
    {
        $responseContent = $event->getResponseContent();
        foreach (['jsonapi', 'included', 'errors', 'meta'] as $position) {
            if(empty($responseContent[$position])) {
                unset($responseContent[$position]);
            }
        }

        if (!empty($responseContent['errors'])) {
            unset($responseContent['data']);
        }

        $event->setResponseContent($responseContent);
    }
}
