<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi.com
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
use Symfony\Component\OptionsResolver\OptionsResolver;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;

/**
 * Class BannerType
 */
class BannerType extends AbstractType
{
    use FactoryTrait;

    /**
     * @var string
     *
     * Image namespace
     */
    protected $imageNamespace;

    /**
     * @var string
     *
     * BannerZone namespace
     */
    protected $bannerZoneNamespace;

    /**
     * Construct
     *
     * @param string $imageNamespace      Image namespace
     * @param string $bannerZoneNamespace BannerZone namespace
     */
    public function __construct($imageNamespace, $bannerZoneNamespace)
    {
        $this->imageNamespace = $imageNamespace;
        $this->bannerZoneNamespace = $bannerZoneNamespace;
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
                'required' => false,
                'label'    => 'name',
            ])
            ->add('description', 'textarea', [
                'required' => false,
                'label'    => 'description',
            ])
            ->add('url', 'text', [
                'required' => false,
                'label'    => 'url',
            ])
            ->add('position', 'integer', [
                'required' => false,
                'label'    => 'position',
            ])
            ->add('enabled', 'checkbox', [
                'required' => false,
                'label'    => 'enabled',
            ])
            ->add('image', 'entity', [
                'class'    => $this->imageNamespace,
                'required' => false,
                'label'    => 'image',
                'multiple' => false,
            ])
            ->add('principalImage', 'entity', [
                'class'    => $this->imageNamespace,
                'required' => false,
                'label'    => 'principalImage',
                'multiple' => false,
            ])
            ->add('bannerZones', 'entity', [
                'class'    => $this->bannerZoneNamespace,
                'required' => false,
                'label'    => 'bannerZones',
                'multiple' => false,
            ]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix()
    {
        return 'elcodi_admin_banner_form_type_banner';
    }

    /**
     * Return unique name for this form
     *
     * @deprecated Deprecated since Symfony 2.8, to be removed from Symfony 3.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
