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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ManufacturerType
 */
class ManufacturerType extends AbstractType
{
    /**
     * @var string
     *
     * Entity namespace
     */
    protected $entityNamespace;

    /**
     * Constructor
     *
     * @param string $entityNamespace Entity names
     */
    public function __construct($entityNamespace)
    {
        $this->entityNamespace = $entityNamespace;
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
            'data_class' => $this->entityNamespace,
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
            ->add('description', 'textarea', array(
                'required' => false,
                'label'    => 'description',
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
            ));
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_admin_product_form_type_manufacturer';
    }
}
