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

namespace Elcodi\Admin\PageBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Elcodi\Component\Page\Entity\Interfaces\PageInterface;

/**
 * Class PermanentPageSubscriber checks if the page that's being handled by the form is persistent to modify the form
 * fields removing the options that are not present for persistent pages.
 */
class PermanentPageSubscriber implements EventSubscriberInterface
{
    /**
     * Gets the events which the class is subscribed to.
     *
     * @return array The array of events and methods to call.
     */
    public static function getSubscribedEvents()
    {
        return [FormEvents::PRE_SET_DATA => 'preSetData'];
    }

    /**
     * This method is called during the Form::setData() call and removes the options that are not allowed for persistent
     * pages.
     *
     * @param FormEvent $event The form event launched.
     */
    public function preSetData(FormEvent $event)
    {
        $page = $event->getData();
        $form = $event->getForm();

        if (($page instanceof PageInterface) && $page->isPersistent()) {
            $form->remove('enabled');
        }
    }
}
