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

namespace Elcodi\Admin\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;
use Elcodi\Component\User\ElcodiUserProperties;

/**
 * Class AdminUserType
 */
class AdminUserType extends AbstractType
{
    use FactoryTrait;

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'empty_data' => function () {
                $this
                    ->factory
                    ->create();
            },
            'data_class' => $this
                ->factory
                ->getEntityNamespace(),
        ]);
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
            ->setMethod('POST')
            ->add('email', 'email', [
                'required' => true,
            ])
            ->add('password', 'password', [
                'constraints' => [
                    new UserPassword(),
                ],
                'mapped' => false,
                'required' => false,
            ])
            ->add('new_password', 'repeated', [
                'mapped' => false,
                'required' => false,
                'type' => 'password',
            ])
            ->add('firstname', 'text', [
                'required' => false,
            ])
            ->add('lastname', 'text', [
                'required' => false,
            ])
            ->add('gender', 'choice', [
                'choices'   => [
                    ElcodiUserProperties::GENDER_MALE => 'admin.user.field.gender.options.male',
                    ElcodiUserProperties::GENDER_FEMALE => 'admin.user.field.gender.options.female',
                ],
                'required' => true,
            ])
            ->add('birthday', 'date', [
                'required' => false,
                'widget'   => 'single_text',
                'format'   => 'yyyy-MM-dd',
            ])
            ->add('enabled', 'checkbox', [
                'required' => false,
            ]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix()
    {
        return 'elcodi_admin_user_form_type_admin_user';
    }

    /**
     * Return unique name for this form
     *
     * @deprecated Deprecated since Symfony 2.8, to be removed from Symfony 3.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
