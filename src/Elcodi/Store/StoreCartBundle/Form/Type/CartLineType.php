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

namespace Elcodi\StoreCartBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\IntegerToLocalizedStringTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CartLineType
 */
class CartLineType extends AbstractType
{
    /**
     * @var string
     *
     * CartLine namespace
     */
    protected $cartLineNamespace;

    /**
     * Constructor
     *
     * @param string $cartLineNamespace CartLine namespace
     */
    public function __construct($cartLineNamespace)
    {
        $this->cartLineNamespace = $cartLineNamespace;
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
            'data_class' => $this->cartLineNamespace,
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
            ->add('quantity', 'integer', [
                'precision'     => 0,
                'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_FLOOR,
                'required'      => true,
                'label'         => false,
                'attr'          => array('min' => 0)
            ]);
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'store_cart_form_type_cart_line';
    }
}
