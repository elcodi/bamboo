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
 */

namespace Elcodi\Admin\CurrencyBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Wrapper\CurrencyWrapper;

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
     * @var string
     *
     * Default currency
     */
    protected $defaultCurrency;

    /**
     * Construct method
     *
     * @param CurrencyWrapper $currencyWrapper Currency Wrapper
     * @param string          $defaultCurrency Default Currency
     */
    public function __construct(
        CurrencyWrapper $currencyWrapper,
        $defaultCurrency
    )
    {
        $this->currencyWrapper = $currencyWrapper;
        $this->defaultCurrency = $defaultCurrency;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', 'integer')
            ->add('currency', 'entity', [
                'class'         => 'Elcodi\Component\Currency\Entity\Currency',
                'query_builder' => function (EntityRepository $repository) {
                    return $repository
                        ->createQueryBuilder('c')
                        ->where('c.enabled = :enabled')
                        ->setParameter('enabled', true);
                },
                'required'      => true,
                'multiple'      => false,
                'property'      => 'symbol',
                'data'          => $this->defaultCurrency,
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
            $this->currencyWrapper->getDefaultCurrency()
        );

        $resolver->setDefaults(array(
            'data_class' => 'Elcodi\Component\Currency\Entity\Money',
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
