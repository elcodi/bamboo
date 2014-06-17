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

namespace Store\StoreUserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ProfileType
 */
class ProfileType extends AbstractType
{
    /**
     * @var string
     *
     * Customer namespace
     */
    protected $customerNamespace;

    /**
     * Constructor
     *
     * @param string $customerNamespace Customer names
     */
    public function __construct($customerNamespace)
    {
        $this->customerNamespace = $customerNamespace;
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
            'data_class' => $this->customerNamespace,
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
            ->add('firstname', 'text', array(
                'required' => true,
                'label'    => 'Firstname',
            ))
            ->add('lastname', 'text', array(
                'required' => true,
                'label'    => 'Lastname',
            ))
            ->add('email', 'email', array(
                'required' => true,
                'label'    => 'Email'
            ))
            ->add('deliveryAddress', 'store_user_form_type_address', array(
                'required' => true,
                'label'    => 'Delivery Address'
            ))
            ->add('invoiceAddress', 'store_user_form_type_address', array(
                'required' => true,
                'label'    => 'Invoice Address'
            ))
            ->add('password', 'repeated', array(
                'type'           => 'password',
                'first_options'  => array(
                    'label' => 'Password',
                ),
                'second_options' => array(
                    'label' => 'Repeat Password',
                ),
                'required'       => false,
            ))
            ->add('send', 'submit', array(
                'label' => 'Save',
            ));
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'store_user_form_type_profile';
    }
}
