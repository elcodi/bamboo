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
     * Buildform function
     *
     * @param FormBuilderInterface $builder the formBuilder
     * @param array                $options the options for this form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', 'text', array(
                'required' => false,
                'label'    => 'code',
            ))
            ->add('name', 'text', array(
                'required' => false,
                'label'    => 'name',
            ))
            ->add('type', 'choice', array(
                'required' => true,
                'label'    => 'type',
                'choices'  => [
                    ElcodiCouponTypes::TYPE_AMOUNT  => 'Amount',
                    ElcodiCouponTypes::TYPE_PERCENT => 'Percent',
                ],
            ))
            ->add('enforcement', 'choice', array(
                'required' => true,
                'label'    => 'type',
                'choices'  => [
                    ElcodiCouponTypes::ENFORCEMENT_MANUAL    => 'Manual application',
                    ElcodiCouponTypes::ENFORCEMENT_AUTOMATIC => 'Automatic application',
                ],
            ))
            ->add('price', 'money_object', array(
                'required' => false,
                'label'    => 'priceAmount',
            ))
            ->add('discount', 'integer', array(
                'required' => false,
                'label'    => 'discount',
            ))
            ->add('count', 'integer', array(
                'required' => false,
                'label'    => 'count',
            ))
            ->add('used', 'checkbox', array(
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
            ->add('validFrom', 'datetime', array(
                'widget'   => 'single_text',
                'format'   => 'yyyy-MM-dd - HH:mm:ss',
                'required' => false,
                'label'    => 'validFrom',
            ))
            ->add('validTo', 'datetime', array(
                'widget'   => 'single_text',
                'format'   => 'yyyy-MM-dd - HH:mm:ss',
                'required' => false,
                'label'    => 'validTo',
            ))
            ->add('createdAt', 'datetime', array(
                'widget'   => 'single_text',
                'format'   => 'yyyy-MM-dd - HH:mm:ss',
                'required' => false,
                'label'    => 'createdAt',
            ))
            ->add('updatedAt', 'datetime', array(
                'widget'   => 'single_text',
                'format'   => 'yyyy-MM-dd - HH:mm:ss',
                'required' => false,
                'label'    => 'updatedAt',
            ))
            ->add('enabled', 'checkbox', array(
                'required' => false,
                'label'    => 'enabled',
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
