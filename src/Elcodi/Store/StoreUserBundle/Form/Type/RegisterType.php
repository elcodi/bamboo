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

namespace Elcodi\StoreUserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class RegisterType
 */
class RegisterType extends AbstractType
{
    /**
     * Buildform function
     *
     * @param FormBuilderInterface $builder the formBuilder
     * @param array                $options the options for this form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->setMethod('POST')
            ->add('firstname', 'text', [
                'required' => true,
                'label'    => 'Firstname',
            ])
            ->add('lastname', 'text', [
                'required' => true,
                'label'    => 'Lastname',
            ])
            ->add('email', 'email', [
                'required' => true,
                'label'    => 'Email'
            ])
            ->add('username', 'text', [
                'required' => true,
                'label'    => 'Username'
            ])
            ->add('password', 'repeated', [
                'type'           => 'password',
                'first_options'  => [
                    'label' => 'Password',
                ],
                'second_options' => [
                    'label' => 'Repeat Password',
                ],
                'required'       => false,
            ])
            ->add('send', 'submit', [
                'label' => 'Register',
            ]);
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'store_user_form_type_register';
    }
}
