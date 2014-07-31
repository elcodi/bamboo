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

namespace Elcodi\AdminCurrencyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\CurrencyBundle\Wrapper\CurrencyWrapper;

/**
 * Class MoneyType
 */
class MoneyType extends AbstractType
{
    /**
     * @var CurrencyWrapper
     *
     * Currency Wrapper
     */
    protected $currencyManager;

    /**
     * Construct method
     *
     * @param CurrencyWrapper $currencyWrapper Currency Wrapper
     */
    public function __construct(CurrencyWrapper $currencyWrapper)
    {
        $this->currencyWrapper = $currencyWrapper;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', 'integer')
            ->add('currency', 'entity', [
                'class'    => 'Elcodi\CurrencyBundle\Entity\Currency',
                'required' => true,
                'multiple' => false,
                'property' => 'symbol'
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        /**
         * We set given Currency as default object to work with
         */
        $money = Money::create(
            0,
            $this->currencyWrapper->getCurrency()
        );

        $resolver->setDefaults(array(
            'data_class' => 'Elcodi\CurrencyBundle\Entity\StubMoney',
            'empty_data' => $money,
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'money_object';
    }
}
