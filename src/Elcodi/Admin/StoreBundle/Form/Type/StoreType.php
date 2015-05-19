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

namespace Elcodi\Admin\ShippingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;

/**
 * Class StoreType
 */
class StoreType extends AbstractType
{
    use FactoryTrait;

    /**
     * @var string
     *
     * Currency namespace
     */
    protected $currencyNamespace;

    /**
     * @var string
     *
     * Language namespace
     */
    protected $languageNamespace;

    /**
     * Construct
     *
     * @param string $currencyNamespace Currency namespace
     * @param string $languageNamespace Language namespace
     */
    public function __construct(
        $currencyNamespace,
        $languageNamespace
    ) {
        $this->currencyNamespace = $currencyNamespace;
        $this->languageNamespace = $languageNamespace;
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
            ->add('phone', 'text', [
                'required' => false,
            ])
            ->add('email', 'text', [
                'required' => false,
            ])
            ->add('underConstruction', 'boolean', [
                'required' => false,
            ])
            ->add('useStock', 'boolean', [
                'required' => false,
            ])
            ->add('enabled', 'boolean', [
                'required' => false,
            ])
            ->add('defaultLanguage', 'entity', [
                'class'    => $this->languageNamespace,
                'required' => true,
                'multiple' => false,
            ])
            ->add('defaultCurrency', 'entity', [
                'class'    => $this->currencyNamespace,
                'required' => true,
                'multiple' => false,
            ]);
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_admin_store_form_type_store';
    }
}
