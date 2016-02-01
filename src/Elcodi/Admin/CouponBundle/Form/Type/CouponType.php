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

namespace Elcodi\Admin\CouponBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;
use Elcodi\Component\Coupon\ElcodiCouponTypes;

/**
 * Class CouponType
 */
class CouponType extends AbstractType
{
    use FactoryTrait;

    /**
     * @var string
     *
     * Namespace for the rule class
     */
    protected $ruleNamespace;

    /**
     * Constructor
     *
     * @param string $ruleNamespace Rule namespace
     */
    public function __construct($ruleNamespace)
    {
        $this->ruleNamespace = $ruleNamespace;
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
            ->add('code', 'text', [
                'required' => true,
            ])
            ->add('name', 'text', [
                'required' => true,
            ])
            ->add('type', 'choice', [
                'required' => true,
                'choices'  => [
                    ElcodiCouponTypes::TYPE_AMOUNT  => 'admin.coupon.field.type.options.fixed',
                    ElcodiCouponTypes::TYPE_PERCENT => 'admin.coupon.field.type.options.percent',
                ],
            ])
            ->add('enforcement', 'choice', [
                'required' => true,
                'choices'  => [
                    ElcodiCouponTypes::ENFORCEMENT_MANUAL    => 'admin.coupon.field.enforcement.options.manual',
                    ElcodiCouponTypes::ENFORCEMENT_AUTOMATIC => 'admin.coupon.field.enforcement.options.automatic',
                ],
            ])
            ->add('price', 'money_object', [
                'required' => false,
            ])
            ->add('discount', 'integer', [
                'required' => false,
            ])
            ->add('count', 'integer', [
                'required' => false,
            ])
            ->add('used', 'integer', [
                'required' => false,
            ])
            ->add('priority', 'integer', [
                'required' => false,
            ])
            ->add('minimumPurchase', 'money_object', [
                'required' => false,
            ])
            ->add('stackable', 'checkbox', [
                'required' => false,
            ])
            ->add('rule', 'entity', [
                'class'       => $this->ruleNamespace,
                'required'    => false,
                'property'    => 'name',
                'placeholder' => true,
                'empty_data'  => null,
            ])
            ->add('validFrom', 'datetime', [
                'date_widget'  => 'single_text',
                'date_format'  => 'yyyy-MM-dd',
                'time_widget'  => 'single_text',
                'required'     => false,
            ])
            ->add('validTo', 'datetime', [
                'date_widget'  => 'single_text',
                'date_format'  => 'yyyy-MM-dd',
                'time_widget'  => 'single_text',
                'required'     => false,
            ])
            ->add('enabled', 'checkbox', [
                'required' => false,
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
        return 'elcodi_admin_coupon_form_type_coupon';
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
