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

namespace Elcodi\AdminUserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Elcodi\LanguageBundle\Factory\LanguageFactory;
use Elcodi\UserBundle\ElcodiUserProperties;
use Elcodi\UserBundle\Factory\CustomerFactory;

/**
 * Class CustomerType
 */
class CustomerType extends AbstractType
{
    /**
     * @var CustomerFactory
     *
     * Customer factory
     */
    protected $customerFactory;

    /**
     * @var LanguageFactory
     *
     * Language factory
     */
    protected $languageFactory;

    /**
     * Constructor
     *
     * @param CustomerFactory $customerFactory Customer factory
     * @param LanguageFactory $languageFactory Language factory
     */
    public function __construct(
        CustomerFactory $customerFactory,
        LanguageFactory $languageFactory
    )
    {
        $this->customerFactory = $customerFactory;
        $this->languageFactory = $languageFactory;
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
            'empty_data' => $this->customerFactory->create(),
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
                'required' => false,
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
                'choices'  => array(
                    ElcodiUserProperties::GENDER_MALE   => 'Male',
                    ElcodiUserProperties::GENDER_FEMALE => 'Female',
                ),
                'required' => false,
                'label'    => 'Gender'
            ))
            ->add('language', 'entity', array(
                'class'    => $this->languageFactory->getEntityNamespace(),
                'property' => 'name',
                'required' => false,
                'label'    => 'Preferred language',
            ))
            ->add('birthday', 'date', array(
                'required' => false,
                'widget'   => 'single_text',
                'format'   => 'yyyy-MM-dd',
                'label'    => 'Birthday',
            ))
            ->add('phone', 'text', array(
                'required' => false,
                'label'    => 'Phone',
            ))
            ->add('identityDocument', 'text', array(
                'required' => false,
                'label'    => 'Identity document',
            ))
            ->add('guest', 'checkbox', array(
                'required' => false,
                'label'    => 'Is guest'
            ))
            ->add('newsletter', 'checkbox', array(
                'required' => false,
                'label'    => 'Newsletter subscribed'
            ))
            ->add('enabled', 'checkbox', array(
                'required' => false,
                'label'    => 'Is enabled'
            ));
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'admin_user_form_type_customer';
    }
}
