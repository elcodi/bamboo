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

namespace Elcodi\Plugin\TwitterBundle\EventListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Plugin\TwitterBundle\Services\TwitterUsernameCleaner;

/**
 * Class TwitterUsernameEventListener
 */
class TwitterUsernameEventListener
{
    /**
     * @var TwitterUsernameCleaner
     *
     * A twitter username cleaner service.
     */
    private $twitterUsernameCleaner;

    /**
     * Builds a new twitter username event listener.
     *
     * @param TwitterUsernameCleaner $twitterUsernameCleaner A twitter username
     *                                                       cleaner
     */
    public function __construct(TwitterUsernameCleaner $twitterUsernameCleaner)
    {
        $this->twitterUsernameCleaner = $twitterUsernameCleaner;
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
            == 'Elcodi\Plugin\TwitterBundle\ElcodiTwitterBundle'
        ) {
            $twitterAccount = $entity
                ->getConfiguration()
                ->getFieldValue('twitter_account');

            $entity->getConfiguration()->setFieldValue(
                'twitter_account',
                $this
                    ->twitterUsernameCleaner
                    ->clean($twitterAccount)
            );
        }
    }
}
