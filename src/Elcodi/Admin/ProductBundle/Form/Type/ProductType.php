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
            ->add('name', 'text', array(
                'required' => true,
                'label'    => 'Title'
            ))
            ->add('slug', 'text', array(
                'required' => true,
                'label'    => 'slug',
            ))
            ->add('description', 'textarea', array(
                'required' => true,
                'label'    => 'Description',
            ))
            ->add('showInHome', 'checkbox', array(
                'required' => false,
                'label'    => 'Show in home',
            ))
            ->add('stock', 'hidden', array(
                'required' => true,
                'label'    => 'stock',
            ))
            ->add('price', 'money_object', array(
                'required' => true,
                'label'    => 'Price',
            ))
            ->add('reducedPrice', 'money_object', array(
                'required' => false,
                'label'    => 'Reduced Price',
            ))
            ->add('imagesSort', 'text', array(
                'required' => false,
                'label'    => 'Images sort',
            ))
            ->add('enabled', 'checkbox', array(
                'required' => false,
                'label'    => 'Visible',
            ))
            ->add('metaTitle', 'text', array(
                'required' => false,
                'label'    => 'Metatitle',
            ))
            ->add('metaDescription', 'text', array(
                'required' => false,
                'label'    => 'Metadescription',
            ))
            ->add('metaKeywords', 'text', array(
                'required' => false,
                'label'    => 'Metakeywords',
            ))
            ->add('manufacturer', 'entity', array(
                'class'    => 'Elcodi\Component\Product\Entity\Manufacturer',
                'required' => false,
                'label'    => 'manufacturer',
                'multiple' => false,
            ))
            ->add('principalCategory', 'entity', array(
                'class'    => 'Elcodi\Component\Product\Entity\Category',
                'required' => true,
                'label'    => 'Category',
                'multiple' => false,
            ))
            ->add('images', 'entity', array(
                'class'    => 'Elcodi\Component\Media\Entity\Image',
                'required' => false,
                'property' => 'id',
                'label'    => false,
                'multiple' => true,
            ));

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
