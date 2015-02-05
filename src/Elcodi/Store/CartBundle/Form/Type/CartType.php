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

namespace Elcodi\Store\CartBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class CartType
 */
class CartType extends AbstractType
{
    /**
     * @var string
     *
     * Cart namespace
     */
    protected $cartNamespace;

    /**
     * @var UrlGeneratorInterface
     *
     * Router
     */
    protected $router;

    /**
     * Constructor
     *
     * @param string                $cartNamespace Cart names
     * @param UrlGeneratorInterface $router        Router
     */
    public function __construct(UrlGeneratorInterface $router, $cartNamespace)
    {
        $this->router = $router;
        $this->cartNamespace = $cartNamespace;
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
        $resolver->setDefaults([
            'data_class' => $this->cartNamespace,
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
            ->setAction(
                $this
                    ->router
                    ->generate('store_cart_update')
            )
            ->setMethod('POST')
            ->add('cartLines', 'collection', [
                'type'     => 'store_cart_form_type_cart_line',
                'required' => true,
                'label'    => false,
            ])
            ->add('update', 'submit', [
                'label' => 'Update basket',
            ]);
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'store_cart_form_type_cart';
    }
}
