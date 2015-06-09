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

namespace Elcodi\Admin\StoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;

/**
 * Class StoreCorporateType
 */
class StoreCorporateType extends AbstractType
{
    use FactoryTrait;

    /**
     * @var string
     *
     * image namespace
     */
    protected $imageNamespace;

    /**
     * Construct
     *
     * @param string $imageNamespace image namespace
     */
    public function __construct($imageNamespace)
    {
        $this->imageNamespace = $imageNamespace;
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'empty_data' => function () {
                $this
                    ->factory
                    ->create();
            },
            'data_class' => $this
                ->factory
                ->getEntityNamespace(),
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
            ->add('leitmotiv', 'text', [
                'required' => false,
            ])
            ->add('logo', 'entity', [
                'class'    => $this->imageNamespace,
                'required' => false,
                'multiple' => false,
                'property' => 'id',
            ])
            ->add('secondaryLogo', 'entity', [
                'class'    => $this->imageNamespace,
                'required' => false,
                'multiple' => false,
                'property' => 'id',
            ])
            ->add('mobileLogo', 'entity', [
                'class'    => $this->imageNamespace,
                'required' => false,
                'multiple' => false,
                'property' => 'id',
            ])
            ->add('headerImage', 'entity', [
                'class'    => $this->imageNamespace,
                'required' => false,
                'multiple' => false,
                'property' => 'id',
            ])
            ->add('backgroundImage', 'entity', [
                'class'    => $this->imageNamespace,
                'required' => false,
                'multiple' => false,
                'property' => 'id',
            ]);
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_admin_store_form_type_store_corporate';
    }
}
