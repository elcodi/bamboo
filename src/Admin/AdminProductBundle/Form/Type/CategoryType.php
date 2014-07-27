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

namespace Admin\AdminProductBundle\Form\Type;

use Elcodi\ProductBundle\Factory\CategoryFactory;
use Elcodi\ProductBundle\Factory\ProductFactory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CategoryType
 */
class CategoryType extends AbstractType
{
    /**
     * @var CategoryFactory
     *
     * Category factory
     */
    protected $categoryFactory;

    /**
     * Constructor
     *
     * @param CategoryFactory $categoryFactory Category Factory
     * @param ProductFactory  $productFactory  Product Factory
     */
    public function __construct(
        CategoryFactory $categoryFactory,
        ProductFactory $productFactory
    )
    {
        $this->categoryFactory = $categoryFactory;
        $this->productFactory = $productFactory;
    }

    /**
     * Default form options
     *
     * @param OptionsResolverInterface $resolver
     *
     * @return array With the options
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'empty_data' => $this->categoryFactory->create(),
        ));
    }

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
                'required' => false,
                'label'    => 'name',
            ))
            ->add('slug', 'text', array(
                'required' => false,
                'label'    => 'slug',
            ))
            ->add('root', 'checkbox', array(
                'required' => false,
                'label'    => 'root',
            ))
            ->add('position', 'integer', array(
                'required' => false,
                'label'    => 'position',
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
            ->add('parent', 'entity', array(
                'class'    => $this->categoryFactory->getEntityNamespace(),
                'required' => false,
                'label'    => 'parent',
                'multiple' => false,
            ))
            ->add('products', 'entity', array(
                'class'    => $this->productFactory->getEntityNamespace(),
                'required' => false,
                'label'    => 'products',
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
        return 'elcodi_admin_product_form_type_category';
    }
}
