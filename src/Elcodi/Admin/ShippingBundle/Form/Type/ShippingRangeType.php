<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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
            ->add('name', 'text', [
                'required' => true,
            ])
            ->add('price', 'money_object', [
                'required' => true,
            ])
            ->add('type', 'choice', [
                'choices'  => [
                    ElcodiShippingRangeTypes::TYPE_PRICE => 'admin.shipping_range.field.type.options.price',
                    ElcodiShippingRangeTypes::TYPE_WEIGHT => 'admin.shipping_range.field.type.options.weight',
                ],
                'required' => true,
            ])
            ->add('fromWeight', 'number', [
                'required' => false,
            ])
            ->add('toWeight', 'number', [
                'required' => false,
            ])
            ->add('fromPrice', 'money_object', [
                'required' => false,
            ])
            ->add('toPrice', 'money_object', [
                'required' => false,
            ])
            ->add('toZone', 'entity', [
                'class'    => $this->zoneNamespace,
                'required' => true,
                'property' => 'name',
                'multiple' => false,
            ]);
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
