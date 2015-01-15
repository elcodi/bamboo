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
                'label'    => 'Select one or more attributes:',
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
            ->add('imagesSort', 'text', array(
                'required' => false,
                'label'    => 'Images sort',
            ))
            ->add('images', 'entity', array(
                'class'    => 'Elcodi\Component\Media\Entity\Image',
                'required' => false,
                'property' => 'id',
                'label'    => false,
                'multiple' => true,
            ))
            ->add('stock', 'hidden', array(
                'required' => false,
                'label'    => 'stock',
            ))
            ->add('price', 'money_object', array(
                'required' => false,
                'label'    => 'Price',
            ))
            ->add('reducedPrice', 'money_object', array(
                'required' => false,
                'label'    => 'Reduced Price',
            ))
            ->add('enabled', 'checkbox', array(
                'required' => false,
                'label'    => 'Visible'
            ));
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_admin_product_form_type_product_variant';
    }
}
