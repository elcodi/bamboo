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

namespace Elcodi\Admin\CurrencyBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Elcodi\Component\Core\Wrapper\Interfaces\WrapperInterface;
use Elcodi\Component\Currency\Entity\Money;

/**
 * Class MoneyType
 */
class MoneyType extends AbstractType
{
    /**
     * @var WrapperInterface
     *
     * Currency Wrapper
     */
    protected $defaultCurrencyWrapper;

    /**
     * @var string
     *
     * Default currency iso
     */
    protected $defaultCurrencyIso;

    /**
     * Construct method
     *
     * @param WrapperInterface $defaultCurrencyWrapper Default Currency Wrapper
     * @param string           $defaultCurrencyIso     Default Currency iso
     */
    public function __construct(
        WrapperInterface $defaultCurrencyWrapper,
        $defaultCurrencyIso
    ) {
        $this->defaultCurrencyWrapper = $defaultCurrencyWrapper;
        $this->defaultCurrencyIso = $defaultCurrencyIso;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', 'money', [
                'divisor'  => 100,
                'currency' => false,
            ])
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
                'data'          => $this->defaultCurrencyIso,
            ]);
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        /**
         * We set given Currency as default object to work with
         */
        $money = Money::create(
            0,
            $this
                ->defaultCurrencyWrapper
                ->get()
        );

        $resolver->setDefaults([
            'data_class' => 'Elcodi\Component\Currency\Entity\Money',
            'empty_data' => $money,
        ]);
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
