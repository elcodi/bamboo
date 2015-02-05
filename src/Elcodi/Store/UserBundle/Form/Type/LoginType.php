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
 */

namespace Elcodi\Store\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Type for a shop edit profile form
 */
class LoginType extends AbstractType
{
    /**
     * @var UrlGeneratorInterface
     *
     * Router
     */
    protected $router;

    /**
     * Constructor
     *
     * @param UrlGeneratorInterface $router Router
     */
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Buildform function
     *
     * @param FormBuilderInterface $builder the formBuilder
     * @param array                $options the options for this form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction(
                $this
                    ->router
                    ->generate('store_login_check')
            )
            ->setMethod('POST')
            ->add('email', 'email', [
                'required' => true,
                'label'    => 'Email',
            ])
            ->add('password', 'password', [
                'required' => true,
                'label'    => 'Password',
            ])
            ->add('send', 'submit');
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'store_user_form_type_login';
    }
}
