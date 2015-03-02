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

namespace Elcodi\Store\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class PasswordRecoverType
 */
class PasswordRecoverType extends AbstractType
{
    /**
     * Buildform function
     *
     * @param FormBuilderInterface $builder the formBuilder
     * @param array                $options the options for this form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('password', 'repeated', [
                'type'           => 'password',
                'first_options'  => [
                    'label' => 'store.recovery.form.fields.password.label',
                ],
                'second_options' => [
                    'label' => 'store.recovery.form.fields.repeat_password.label',
                ],
                'required'       => true,
            ])
            ->add('store.recovery.form.fields.send.label', 'submit', [
                'label' => 'Recover',
            ]);
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'store_user_form_type_password_recover';
    }
}
