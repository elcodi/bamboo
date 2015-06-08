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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;

/**
 * Class StoreSettingsType
 */
class StoreSettingsType extends AbstractType
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
            ->add('useStock', 'checkbox', [
                'required' => false,
            ])
            ->add('enabled', 'checkbox', [
                'required' => false,
            ]);
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_admin_store_form_type_store_settings';
    }
}
