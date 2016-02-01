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

namespace Elcodi\Admin\CurrencyBundle\Form\DataMapper;

use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\FormInterface;

use Elcodi\Component\Currency\Entity\Money;

/**
 * Class MoneyDataMapper
 */
class MoneyDataMapper implements DataMapperInterface
{
    /**
     * Maps properties of some data to a list of forms.
     *
     * @param mixed           $data  Structured data.
     * @param FormInterface[] $forms A list of {@link FormInterface} instances.
     *
     * @throws UnexpectedTypeException if the type of the data parameter is not supported.
     */
    public function mapDataToForms($data, $forms)
    {
        foreach ($forms as $form) {
            switch ($form->getName()) {
                case 'amount':
                    $form->setData(bcdiv($data->getAmount(), 100, 2));
                    break;
                case 'currency':
                    $form->setData($data->getCurrency());
                    break;
            }
        }
    }

    /**
     * Maps the data of a list of forms into the properties of some data.
     *
     * @param FormInterface[] $forms A list of {@link FormInterface} instances.
     * @param mixed           $data  Structured data.
     *
     * @throws UnexpectedTypeException if the type of the data parameter is not supported.
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);
        $data = Money::create(
            bcmul($forms['amount']->getData(), 100),
            $forms['currency']->getData()
        );
    }
}
