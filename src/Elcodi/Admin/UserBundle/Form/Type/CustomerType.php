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

use Elcodi\Component\Language\Factory\LanguageFactory;
use Elcodi\Component\User\ElcodiUserProperties;
use Elcodi\Component\User\Factory\CustomerFactory;

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
    ) {
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
                'required' => true,
            ))
            ->add('email', 'email', array(
                'required' => true,
            ))
            ->add('firstname', 'text', array(
                'required' => true,
            ))
            ->add('lastname', 'text', array(
                'required' => true,
            ))
            ->add('gender', 'choice', array(
                'choices'  => array(
                    ElcodiUserProperties::GENDER_MALE => 'admin.user.field.gender.options.male',
                    ElcodiUserProperties::GENDER_FEMALE => 'admin.user.field.gender.options.female',
                ),
                'required' => true,
            ))
            ->add('language', 'entity', array(
                'class'    => $this->languageFactory->getEntityNamespace(),
                'property' => 'name',
                'required' => true,
            ))
            ->add('birthday', 'date', array(
                'required' => false,
                'widget'   => 'single_text',
                'format'   => 'yyyy-MM-dd',
            ))
            ->add('phone', 'text', array(
                'required' => false,
            ))
            ->add('identityDocument', 'text', array(
                'required' => false,
            ))
            ->add('guest', 'checkbox', array(
                'required' => false,
            ))
            ->add('newsletter', 'checkbox', array(
                'required' => false,
            ))
            ->add('enabled', 'checkbox', array(
                'required' => false,
            ));
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_admin_user_form_type_customer';
    }
}
