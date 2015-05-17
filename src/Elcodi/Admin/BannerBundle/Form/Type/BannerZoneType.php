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

namespace Elcodi\Admin\BannerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;

/**
 * Class BannerZoneType
 */
class BannerZoneType extends AbstractType
{
    use FactoryTrait;

    /**
     * @var string
     *
     * language namespace
     */
    protected $languageNamespace;

    /**
     * @var string
     *
     * Banner namespace
     */
    protected $bannerNamespace;

    /**
     * Construct
     *
     * @param string $languageNamespace language namespace
     * @param string $bannerNamespace   Banner namespace
     */
    public function __construct($languageNamespace, $bannerNamespace)
    {
        $this->languageNamespace = $languageNamespace;
        $this->bannerNamespace = $bannerNamespace;
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
                'required' => false,
                'label'    => 'name',
            ])
            ->add('code', 'text', [
                'required' => false,
                'label'    => 'code',
            ])
            ->add('height', 'integer', [
                'required' => false,
                'label'    => 'height',
            ])
            ->add('width', 'integer', [
                'required' => false,
                'label'    => 'width',
            ])
            ->add('language', 'entity', [
                'class'    => $this->languageNamespace,
                'required' => false,
                'label'    => 'language',
                'multiple' => false,
            ])
            ->add('banners', 'entity', [
                'class'    => $this->bannerNamespace,
                'required' => false,
                'label'    => 'banners',
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
        return 'elcodi_admin_form_type_banner_zone';
    }
}
