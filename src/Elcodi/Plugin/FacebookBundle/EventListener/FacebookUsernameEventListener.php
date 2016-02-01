<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi.com
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

namespace Elcodi\Plugin\FacebookBundle\EventListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Plugin\FacebookBundle\Services\FacebookUsernameCleaner;

/**
 * Class FacebookUsernameEventListener
 */
class FacebookUsernameEventListener
{
    /**
     * @var FacebookUsernameCleaner
     *
     * A facebook username cleaner service.
     */
    protected $facebookUsernameCleaner;

    /**
     * Builds a new facebook username event listener.
     *
     * @param FacebookUsernameCleaner $facebookUsernameCleaner A facebook
     *                                                         username
     *                                                         cleanear
     */
    public function __construct(
        FacebookUsernameCleaner $facebookUsernameCleaner
    ) {
        $this->facebookUsernameCleaner = $facebookUsernameCleaner;
    }

    /**
     * Cleans the facebbok username.
     *
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        if (
            $entity instanceof Plugin &&
            $entity->getNamespace()
            == 'Elcodi\Plugin\FacebookBundle\ElcodiFacebookBundle'
        ) {
            $facebookAccount = $entity
                ->getConfiguration()
                ->getFieldValue('facebook_account');

            $entity->getConfiguration()->setFieldValue(
                'facebook_account',
                $this
                    ->facebookUsernameCleaner
                    ->clean($facebookAccount)
            );
        }
    }
}
