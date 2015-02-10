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

namespace Elcodi\Admin\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Elcodi\Component\User\ElcodiUserProperties;
use Elcodi\Component\User\Factory\AdminUserFactory;

/**
 * Class AdminUserType
 */
class AdminUserType extends AbstractType
{
    /**
     * @var AdminUserFactory
     *
     * Customer factory
     */
    protected $adminUserFactory;

    /**
     * Constructor
     *
     * @param AdminUserFactory $adminUserFactory Customer factory
     */
    public function __construct(
        AdminUserFactory $adminUserFactory
    )
    {
        $this->adminUserFactory = $adminUserFactory;
    }

    /**
     * Default form options
     *
     * @param OptionsResolverInterface $resolver
     *
     * @return array With the options
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'empty_data' => $this->adminUserFactory->create(),
        ));
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
            ->add('username', 'text', array(
                'required' => true,
                'label'    => 'Username'
            ))
            ->add('email', 'email', array(
                'required' => true,
                'label'    => 'Email'
            ))
            ->add('firstname', 'text', array(
                'required' => false,
                'label'    => 'Firstname'
            ))
            ->add('lastname', 'text', array(
                'required' => false,
                'label'    => 'Lastname'
            ))
            ->add('gender', 'choice', array(
                'choices'   => array(
                    ElcodiUserProperties::GENDER_MALE => 'Male',
                    ElcodiUserProperties::GENDER_FEMALE => 'Female',
                ),
                'required' => true,
                'label'    => 'Gender'
            ))
            ->add('birthday', 'date', array(
                'required' => false,
                'widget'   => 'single_text',
                'format'   => 'yyyy-MM-dd',
                'label'    => 'Birthday',
            ))
            ->add('enabled', 'checkbox', array(
                'required' => false,
                'label'    => 'Status'
            ));
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_admin_user_form_type_admin_user';
    }
}
