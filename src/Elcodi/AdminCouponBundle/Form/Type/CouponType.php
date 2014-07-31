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

namespace Elcodi\AdminCouponBundle\Form\Type;

use Elcodi\CouponBundle\ElcodiCouponTypes;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;
use Elcodi\CouponBundle\Factory\CouponFactory;
use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\CurrencyBundle\Factory\CurrencyFactory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CouponType
 */
class CouponType extends AbstractType
{
    /**
     * @var string
     *
     * Entity namespace
     */
    protected $entityNamespace;

    /**
     * @var CouponFactory
     *
     * productFactory
     */
    protected $couponFactory;

    /**
     * @var CurrencyFactory
     *
     * currencyFactory
     */
    protected $currencyFactory;

    /**
     * Construct method
     *
     * @param string          $entityNamespace Entity namespace
     * @param CouponFactory   $couponFactory   Coupon Factory
     * @param CurrencyFactory $currencyFactory Currency factory
     */
    public function __construct(
        $entityNamespace,
        CouponFactory $couponFactory,
        CurrencyFactory $currencyFactory
    )
    {
        $this->entityNamespace = $entityNamespace;
        $this->couponFactory = $couponFactory;
        $this->currencyFactory = $currencyFactory;
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
        $money = Money::create(1, $this->currencyFactory->create()->setIso('EUR'));

        /**
         * @var CouponInterface $coupon
         */
        $coupon = $this->couponFactory->create();
        $coupon->setPrice($money);
        $coupon->setMinimumPurchase($money);

        $resolver->setDefaults(array(
            'empty_data' => $coupon
        ));
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
