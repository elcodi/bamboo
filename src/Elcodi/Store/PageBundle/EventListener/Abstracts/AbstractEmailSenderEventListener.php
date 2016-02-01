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

namespace Elcodi\Store\PageBundle\EventListener\Abstracts;

use Swift_Mailer;
use Twig_Environment;

use Elcodi\Component\Page\Entity\Interfaces\PageInterface;
use Elcodi\Component\Page\Repository\PageRepository;
use Elcodi\Component\Store\Entity\Interfaces\StoreInterface;
use Elcodi\Store\CoreBundle\Services\TemplateLocator;

/**
 * Class AbstractEmailSenderEventListener
 */
abstract class AbstractEmailSenderEventListener
{
    /**
     * @var Swift_Mailer
     *
     * Mailer
     */
    protected $mailer;

    /**
     * @var Twig_Environment
     *
     * Twig
     */
    protected $twig;

    /**
     * @var PageRepository
     *
     * Page repository
     */
    protected $pageRepository;

    /**
     * @var StoreInterface
     *
     * Store
     */
    protected $store;

    /**
     * Construct
     *
     * @param Swift_Mailer     $mailer          Mailer
     * @param Twig_Environment $twig            Twig
     * @param PageRepository   $pageRepository  Page repository
     * @param TemplateLocator  $templateLocator A template locator
     * @param StoreInterface   $store           Store
     */
    public function __construct(
        Swift_Mailer $mailer,
        Twig_Environment $twig,
        PageRepository $pageRepository,
        StoreInterface $store,
        TemplateLocator $templateLocator
    ) {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->pageRepository = $pageRepository;
        $this->store = $store;
        $this->templateLocator = $templateLocator;
    }

    /**
     * Send email
     *
     * @param string $emailName     Email name
     * @param array  $context       Context
     * @param string $receiverEmail Receiver email
     */
    protected function sendEmail($emailName, array $context, $receiverEmail)
    {
        $page = $this
            ->pageRepository
            ->findOneBy([
                'name' => $emailName,
            ]);

        if ($page instanceof PageInterface) {
            $template = $this
                ->templateLocator
                ->locate(':email.html.twig');

            $resolvedPage = $this
                ->twig
                ->render($template, array_merge([
                    'title' => $page->getTitle(),
                    'content' => $page->getContent(),
                ], $context));

            $message = $this
                ->mailer
                ->createMessage()
                ->setSubject($page->getTitle())
                ->setFrom($this->store->getEmail())
                ->setTo($receiverEmail)
                ->setBody($resolvedPage, 'text/html');

            $this
                ->mailer
                ->send($message);
        }
    }
}
