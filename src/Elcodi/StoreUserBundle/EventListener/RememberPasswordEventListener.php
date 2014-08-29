<?php

/**
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
 */

namespace Elcodi\StoreUserBundle\EventListener;

use Swift_Mailer;
use Swift_Message;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Templating\EngineInterface;

use Elcodi\Component\User\Event\PasswordRecoverEvent;
use Elcodi\Component\User\Event\PasswordRememberEvent;

/**
 * Password event listener
 */
class RememberPasswordEventListener
{
    /**
     * @var Swift_Mailer
     *
     * Mailer
     */
    protected $mailer;

    /**
     * @var EngineInterface
     *
     * Templating
     */
    protected $templating;

    /**
     * @var SecurityContextInterface
     *
     * SecurityContext
     */
    protected $securityContext;

    /**
     * Build method
     *
     * @param Swift_Mailer             $mailer          Mailer
     * @param EngineInterface          $templating      Templating
     * @param SecurityContextInterface $securityContext Security context
     */
    public function __construct(
        Swift_Mailer $mailer,
        EngineInterface $templating,
        SecurityContextInterface $securityContext
    )
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->securityContext = $securityContext;
    }

    /**
     * on Password Remember event
     *
     * @param PasswordRememberEvent $event Password remember event
     */
    public function onPasswordRemember(PasswordRememberEvent $event)
    {
        $user = $event->getUser();
        $rememberUrl = $event->getRememberUrl();
        $userMail = $user->getEmail();

        $message = Swift_Message::newInstance()
            ->setSubject('Recover your password')
            ->setFrom('no-reply@elcodi.com', 'Elcodi team')
            ->setTo($userMail)
            ->setBody($this->templating->render(
                'StoreUserBundle:Password:email/recover_password.html.twig',
                [
                    'customer'    => $user,
                    'recover_url' => $rememberUrl,
                ]
            ))
            ->setContentType('text/html');

        $this->mailer->send($message);
    }

    /**
     * on Password Recover event
     *
     * When a password is recovered, we must always create new token
     * with current user. It means that recover a password always will mean
     * log in the website
     *
     * @param PasswordRecoverEvent $event Password recover event
     */
    public function onPasswordRecover(PasswordRecoverEvent $event)
    {
        $user = $event->getUser();

        $token = new UsernamePasswordToken(
            $user,
            null,
            'customer_secured_area',
            $user->getRoles()
        );

        $this->securityContext->setToken($token);
    }
}
