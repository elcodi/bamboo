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

/**
 * Class BannerType
 */
class BannerType extends AbstractType
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
                'class'    => 'Elcodi\Component\Media\Entity\Image',
                'required' => false,
                'label'    => 'image',
                'multiple' => false,
            ])
            ->add('principalImage', 'entity', [
                'class'    => 'Elcodi\Component\Media\Entity\Image',
                'required' => false,
                'label'    => 'principalImage',
                'multiple' => false,
            ])
            ->add('bannerZones', 'entity', [
                'class'    => 'Elcodi\Component\Banner\Entity\BannerZone',
                'required' => false,
                'label'    => 'bannerZones',
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
        return 'elcodi_admin_banner_form_type_banner';
    }
}
