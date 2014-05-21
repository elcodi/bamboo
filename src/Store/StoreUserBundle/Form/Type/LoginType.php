<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  * @version
 */

namespace Store\StoreUserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
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
     * @var string
     *
     * Customer namespace
     */
    protected $customerNamespace;

    /**
     * Constructor
     *
     * @param UrlGeneratorInterface $router            Router
     * @param string                $customerNamespace Customer names
     */
    public function __construct(
        UrlGeneratorInterface $router,
        $customerNamespace
    )
    {
        $this->router = $router;
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
            ->setAction(
                $this
                    ->router
                    ->generate('store_login_check')
            )
            ->setMethod('POST')
            ->add('username', 'email', array(
                'required' => true,
                'label' =>  'Email'
            ))
            ->add('password', 'password', array(
                'required' => true,
                'label' =>  'Password'
            ))
            ->add('send', 'submit');
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'store_user_form_types_login';
    }
}