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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Elcodi\Component\EntityTranslator\EventListener\Traits\EntityTranslatableFormTrait;
use Elcodi\Component\Product\Factory\CategoryFactory;
use Elcodi\Component\Product\Factory\ProductFactory;

/**
 * Class CategoryType
 */
class CategoryType extends AbstractType
{
    use EntityTranslatableFormTrait;

    /**
     * @var CategoryFactory
     *
     * Category factory
     */
    protected $categoryFactory;

    /**
     * @var ProductFactory
     *
     * Product factory
     */
    protected $productFactory;

    /**
     * Constructor
     *
     * @param CategoryFactory $categoryFactory Category Factory
     * @param ProductFactory  $productFactory  Product Factory
     */
    public function __construct(
        CategoryFactory $categoryFactory,
        ProductFactory $productFactory
    ) {
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
                'required' => true,
                'label'    => 'name',
            ))
            ->add('slug', 'text', array(
                'required' => false,
                'label'    => 'slug',
            ))
            ->add('root', 'checkbox', array(
                'required' => false,
                'label'    => 'Root Category',
            ))
            ->add('enabled', 'checkbox', array(
                'required' => false,
                'label'    => 'Visible',
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
        return 'elcodi_admin_product_form_type_category';
    }
}
