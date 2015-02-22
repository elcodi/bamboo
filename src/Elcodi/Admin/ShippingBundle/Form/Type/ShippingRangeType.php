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

namespace Elcodi\Admin\ShippingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Elcodi\Component\Shipping\ElcodiShippingRangeTypes;

/**
 * Class ShippingRangeType
 */
class ShippingRangeType extends AbstractType
{
    /**
     * @var string
     *
     * Zone namespace
     */
    protected $zoneNamespace;

    /**
     * Construct
     *
     * @param string $zoneNamespace Zone namespace
     */
    public function __construct($zoneNamespace)
    {
        $this->zoneNamespace = $zoneNamespace;
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
            ->add('save', 'submit')
            ->add('name', 'text', array(
                'required' => true,
                'label'    => 'Shipping rate name',
            ))
            ->add('price', 'money_object', array(
                'required' => true,
                'label'    => 'Price',
            ))
            ->add('type', 'choice', array(
                'choices'  => array(
                    ElcodiShippingRangeTypes::TYPE_PRICE => 'Based on order price',
                    ElcodiShippingRangeTypes::TYPE_WEIGHT => 'Based on order weight',
                ),
                'required' => true,
                'label'    => 'Price will be calculated...',
            ))
            ->add('fromWeight', 'number', array(
                'required' => false,
                'label'    => 'From weight',
            ))
            ->add('toWeight', 'number', array(
                'required' => false,
                'label'    => 'To weight',
            ))
            ->add('fromPrice', 'money_object', array(
                'required' => false,
                'label'    => 'From price',
            ))
            ->add('toPrice', 'money_object', array(
                'required' => false,
                'label'    => 'To price',
            ))
            ->add('toZone', 'entity', array(
                'class'    => $this->zoneNamespace,
                'required' => true,
                'label'    => 'Zone',
                'property' => 'name',
                'multiple' => false,
            ));
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_admin_shipping_form_type_shipping_range';
    }
}
