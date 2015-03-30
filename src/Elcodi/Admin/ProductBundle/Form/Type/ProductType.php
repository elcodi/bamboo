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

namespace Elcodi\Admin\ProductBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

use Elcodi\Admin\CurrencyBundle\Form\Type\Abstracts\AbstractPurchasableType;
use Elcodi\Component\EntityTranslator\EventListener\Traits\EntityTranslatableFormTrait;

/**
 * Class ProductType
 */
class ProductType extends AbstractPurchasableType
{
    use EntityTranslatableFormTrait;

    /**
     * Buildform function
     *
     * @param FormBuilderInterface $builder the formBuilder
     * @param array                $options the options for this form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'required' => true,
            ])
            ->add('slug', 'text', [
                'required' => true,
            ])
            ->add('description', 'textarea', [
                'required' => true,
            ])
            ->add('showInHome', 'checkbox', [
                'required' => false,
            ])
            ->add('stock', 'hidden', [
                'required' => true,
            ])
            ->add('price', 'money_object', [
                'required' => true,
            ])
            ->add('reducedPrice', 'money_object', [
                'required' => false,
            ])
            ->add('imagesSort', 'text', [
                'required' => false,
            ])
            ->add('enabled', 'checkbox', [
                'required' => false,
            ])
            ->add('height', 'number', [
                'required' => false,
            ])
            ->add('width', 'number', [
                'required' => false,
            ])
            ->add('depth', 'number', [
                'required' => false,
            ])
            ->add('weight', 'number', [
                'required' => false,
            ])
            ->add('metaTitle', 'text', [
                'required' => false,
            ])
            ->add('metaDescription', 'text', [
                'required' => false,
            ])
            ->add('metaKeywords', 'text', [
                'required' => false,
            ])
            ->add('stock', 'number', [
                'required' => false,
            ])
            ->add('manufacturer', 'entity', [
                'class'    => 'Elcodi\Component\Product\Entity\Manufacturer',
                'required' => false,
                'multiple' => false,
            ])
            ->add('principalCategory', 'entity', [
                'class'    => 'Elcodi\Component\Product\Entity\Category',
                'required' => true,
                'multiple' => false,
            ])
            ->add('images', 'entity', [
                'class'    => 'Elcodi\Component\Media\Entity\Image',
                'required' => false,
                'property' => 'id',
                'multiple' => true,
                'expanded' => true,
            ]);

        $builder->addEventSubscriber($this->getEntityTranslatorFormEventListener());
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_admin_product_form_type_product';
    }
}
