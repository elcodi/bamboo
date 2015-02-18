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
                'label'    => 'Code',
            ))
            ->add('name', 'text', array(
                'required' => false,
                'label'    => 'Description',
            ))
            ->add('type', 'choice', array(
                'required' => true,
                'label'    => 'Type',
                'choices'  => [
                    ElcodiCouponTypes::TYPE_AMOUNT  => 'Fixed amount',
                    ElcodiCouponTypes::TYPE_PERCENT => 'Percent amount',
                ],
            ))
            ->add('enforcement', 'choice', array(
                'required' => true,
                'label'    => 'Mode',
                'choices'  => [
                    ElcodiCouponTypes::ENFORCEMENT_MANUAL    => 'Manual application',
                    ElcodiCouponTypes::ENFORCEMENT_AUTOMATIC => 'Automatic application',
                ],
            ))
            ->add('price', 'money_object', array(
                'required' => false,
                'label'    => 'Amount',
            ))
            ->add('discount', 'integer', array(
                'required' => false,
                'label'    => '% Amount',
            ))
            ->add('count', 'integer', array(
                'required' => false,
                'label'    => 'Usage Limit',
            ))
            ->add('used', 'integer', array(
                'required' => false,
                'label'    => 'used',
            ))
            ->add('priority', 'integer', array(
                'required' => false,
                'label'    => 'priority',
            ))
            ->add('minimumPurchase', 'money_object', array(
                'required' => false,
                'label'    => 'Minimum purchase',
            ))
            ->add('rule', 'entity', array(
                'class'       => $this->ruleNamespace,
                'required'    => false,
                'label'       => 'Rule',
                'property'    => 'name',
                'placeholder' => 'No rule',
                'empty_data'  => null,
            ))
            ->add('validFrom', 'datetime', array(
                'date_widget'  => 'single_text',
                'date_format'  => 'yyyy-MM-dd',
                'time_widget'  => 'single_text',
                'required'     => false,
                'label'        => 'From',
            ))
            ->add('validTo', 'datetime', array(
                'date_widget'  => 'single_text',
                'date_format'  => 'yyyy-MM-dd',
                'time_widget'  => 'single_text',
                'required'     => false,
                'label'        => 'to',
            ))
            ->add('enabled', 'checkbox', array(
                'required' => false,
                'label'    => 'Status',
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
