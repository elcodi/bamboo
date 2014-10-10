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

namespace Elcodi\AdminProductBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

use Elcodi\AdminCurrencyBundle\Form\Type\Abstracts\AbstractPurchasableType;
use Elcodi\Component\Attribute\Repository\ValueRepository;

/**
 * Class ProductType
 */
class VariantType extends AbstractPurchasableType
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
            ->add('options', 'entity', array(
                'class'    => 'Elcodi\Component\Attribute\Entity\Value',
                'required' => true,
                'label'    => 'options',
                'multiple' => true,
                'group_by' => 'attribute',
                'query_builder' =>
                    function (ValueRepository $valueRepository) {
                        return $valueRepository
                            ->createQueryBuilder('v')
                            ->join('v.attribute', 'a');
                    },
                'property' => 'name'
            ))
            ->add('stock', 'integer', array(
                'required' => false,
                'label'    => 'stock',
            ))
            ->add('price', 'money_object', array(
                'required' => false,
                'label'    => 'price',
            ))
            ->add('reducedPrice', 'money_object', array(
                'required' => false,
                'label'    => 'reducedPrice',
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
        return 'elcodi_admin_product_form_type_variant';
    }
}
