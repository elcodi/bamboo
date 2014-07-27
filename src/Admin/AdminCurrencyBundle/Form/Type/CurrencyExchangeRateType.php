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

namespace Admin\AdminCurrencyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class CurrencyExchangeRateType
 */
class CurrencyExchangeRateType extends AbstractType
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
            ->add('exchangeRate', 'number', array(
                'required' => false,
                'label'    => 'exchangeRate',
            ))
            ->add('targetCurrency', 'entity', array(
                'class'    => 'Elcodi\CurrencyBundle\Entity\Currency',
                'required' => false,
                'label'    => 'targetCurrency',
                'multiple' => false,
            ))
            ->add('sourceCurrency', 'entity', array(
                'class'    => 'Elcodi\CurrencyBundle\Entity\Currency',
                'required' => false,
                'label'    => 'sourceCurrency',
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
        return 'elcodi_admin_currency_form_type_currency_exchange_rate';
    }
}
