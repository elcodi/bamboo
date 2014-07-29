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

use Elcodi\AdminProductBundle\Form\Type\Abstracts\AbstractPurchasableType;

/**
 * Class ProductType
 */
class ProductType extends AbstractPurchasableType
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
            ->add('name', 'text', array(
                'required' => true,
                'label'    => 'name',
            ))
            ->add('slug', 'text', array(
                'required' => true,
                'label'    => 'slug',
            ))
            ->add('shortDescription', 'text', array(
                'required' => false,
                'label'    => 'shortDescription',
            ))
            ->add('description', 'textarea', array(
                'required' => false,
                'label'    => 'description',
            ))
            ->add('showInHome', 'checkbox', array(
                'required' => false,
                'label'    => 'showInHome',
            ))
            ->add('dimensions', 'text', array(
                'required' => false,
                'label'    => 'dimensions',
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
            ))
            ->add('metaTitle', 'text', array(
                'required' => false,
                'label'    => 'metaTitle',
            ))
            ->add('metaDescription', 'text', array(
                'required' => false,
                'label'    => 'metaDescription',
            ))
            ->add('metaKeywords', 'text', array(
                'required' => false,
                'label'    => 'metaKeywords',
            ))
            ->add('manufacturer', 'entity', array(
                'class'    => 'Elcodi\ProductBundle\Entity\Manufacturer',
                'required' => false,
                'label'    => 'manufacturer',
                'multiple' => false,
            ))
            ->add('principalCategory', 'entity', array(
                'class'    => 'Elcodi\ProductBundle\Entity\Category',
                'required' => false,
                'label'    => 'principalCategory',
                'multiple' => false,
            ))
            ->add('principalImage', 'entity', array(
                'class'    => 'Elcodi\MediaBundle\Entity\Image',
                'required' => false,
                'label'    => 'principalImage',
                'multiple' => false,
            ))
            ->add('categories', 'entity', array(
                'class'    => 'Elcodi\ProductBundle\Entity\Category',
                'required' => false,
                'label'    => 'categories',
                'multiple' => true,
            ))
            ->add('images', 'entity', array(
                'class'    => 'Elcodi\MediaBundle\Entity\Image',
                'required' => false,
                'label'    => 'images',
                'multiple' => true,
            ));
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
