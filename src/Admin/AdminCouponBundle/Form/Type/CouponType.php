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

namespace Admin\AdminCouponBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class CouponType
 */
class CouponType extends AbstractType
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
            ->add('type', 'integer', array(
                'required' => false,
                'label'    => 'type',
            ))
            ->add('priceAmount', 'integer', array(
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
            ->add('used', 'integer', array(
                'required' => false,
                'label'    => 'used',
            ))
            ->add('priority', 'integer', array(
                'required' => false,
                'label'    => 'priority',
            ))
            ->add('minimumPurchaseAmount', 'number', array(
                'required' => false,
                'label'    => 'minimumPurchaseAmount',
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
            ))
            ->add('priceCurrency', 'entity', array(
                'class'    => 'Elcodi\CurrencyBundle\Entity\Currency',
                'required' => false,
                'label'    => 'priceCurrency',
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
        return 'elcodi_admin_coupon_form_type_coupon';
    }
}
