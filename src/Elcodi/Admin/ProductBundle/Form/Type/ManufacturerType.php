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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Admin\ProductBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Elcodi\Component\EntityTranslator\EventListener\Traits\EntityTranslatableFormTrait;

/**
 * Class ManufacturerType
 */
class ManufacturerType extends AbstractType
{
    use EntityTranslatableFormTrait;

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
        $resolver->setDefaults([
            'data_class' => $this->entityNamespace,
        ]);
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
            ->add('name', 'text', [
                'required' => true,
            ])
            ->add('slug', 'text', [
                'required' => false,
            ])
            ->add('description', 'textarea', [
                'required' => false,
            ])
            ->add('imagesSort', 'text', [
                'required' => false,
            ])
            ->add('images', 'entity', [
                'class'    => 'Elcodi\Component\Media\Entity\Image',
                'required' => false,
                'property' => 'id',
                'multiple' => true,
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
            ->add('enabled', 'checkbox', [
                'required' => false,
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
        return 'elcodi_admin_product_form_type_manufacturer';
    }
}
