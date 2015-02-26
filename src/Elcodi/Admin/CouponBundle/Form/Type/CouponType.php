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

namespace Elcodi\Admin\CouponBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

use Elcodi\Admin\CurrencyBundle\Form\Type\Abstracts\AbstractPurchasableType;
use Elcodi\Component\Coupon\ElcodiCouponTypes;

/**
 * Class CouponType
 */
class CouponType extends AbstractPurchasableType
{
    /**
     * @var string
     *
     * Namespace for the rule class
     */
    protected $ruleNamespace;

    /**
     * Set namespace for relationship with rules
     *
     * @param string $ruleNamespace rule namespace
     */
    public function setRuleNamespace($ruleNamespace)
    {
        $this->ruleNamespace = $ruleNamespace;
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
            ->add('code', 'text', array(
                'required' => true,
            ))
            ->add('name', 'text', array(
                'required' => false,
            ))
            ->add('type', 'choice', array(
                'required' => true,
                'choices'  => [
                    ElcodiCouponTypes::TYPE_AMOUNT  => 'admin.coupon.field.type.options.fixed',
                    ElcodiCouponTypes::TYPE_PERCENT => 'admin.coupon.field.type.options.percent',
                ],
            ))
            ->add('enforcement', 'choice', array(
                'required' => true,
                'choices'  => [
                    ElcodiCouponTypes::ENFORCEMENT_MANUAL    => 'admin.coupon.field.enforcement.options.manual',
                    ElcodiCouponTypes::ENFORCEMENT_AUTOMATIC => 'admin.coupon.field.enforcement.options.automatic',
                ],
            ))
            ->add('price', 'money_object', array(
                'required' => false,
            ))
            ->add('discount', 'integer', array(
                'required' => false,
            ))
            ->add('count', 'integer', array(
                'required' => false,
            ))
            ->add('used', 'integer', array(
                'required' => false,
            ))
            ->add('priority', 'integer', array(
                'required' => false,
            ))
            ->add('minimumPurchase', 'money_object', array(
                'required' => false,
            ))
            ->add('rule', 'entity', array(
                'class'       => $this->ruleNamespace,
                'required'    => false,
                'property'    => 'name',
                'placeholder' => true,
                'empty_data'  => null,
            ))
            ->add('validFrom', 'datetime', array(
                'date_widget'  => 'single_text',
                'date_format'  => 'yyyy-MM-dd',
                'time_widget'  => 'single_text',
                'required'     => false,
            ))
            ->add('validTo', 'datetime', array(
                'date_widget'  => 'single_text',
                'date_format'  => 'yyyy-MM-dd',
                'time_widget'  => 'single_text',
                'required'     => false,
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
        return 'elcodi_admin_coupon_form_type_coupon';
    }
}
