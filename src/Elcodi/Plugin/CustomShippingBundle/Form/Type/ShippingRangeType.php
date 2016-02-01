<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi.com
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

namespace Elcodi\Plugin\CustomShippingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;
use Elcodi\Plugin\CustomShippingBundle\ElcodiShippingRangeTypes;

/**
 * Class ShippingRangeType
 */
class ShippingRangeType extends AbstractType
{
    use FactoryTrait;

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
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'empty_data' => function () {
                $this
                    ->factory
                    ->create();
            },
            'data_class' => $this
                ->factory
                ->getEntityNamespace(),
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
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix()
    {
        return 'elcodi_plugin_custom_shipping_form_type_shipping_range';
    }

    /**
     * Return unique name for this form
     *
     * @deprecated Deprecated since Symfony 2.8, to be removed from Symfony 3.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
