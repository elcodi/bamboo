<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  * @version  */
 
namespace Store\StoreUserBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\True;

/**
 * Class RegisterType
 */
class RegisterType extends AbstractType
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
                    ->generate('store_register')
            )
            ->setMethod('POST')
            ->add('firstname', 'text', array(
                'required' => true,
                'label' => 'Firstname',
            ))
            ->add('lastname', 'text', array(
                'required' => true,
                'label' => 'Lastname',
            ))
            ->add('username', 'email', array(
                'required' => true,
                'label' =>  'Username'
            ))
            ->add('email', 'email', array(
                'required' => true,
                'label' =>  'Email'
            ))
            ->add('password', 'repeated', array(
                'type' =>   'password',
                'first_options'  => array(
                    'label' => 'Password',
                ),
                'second_options' => array(
                    'label' => 'Repeat Password',
                ),
                'required' => true,
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
        return 'store_user_form_types_register';
    }
}
 