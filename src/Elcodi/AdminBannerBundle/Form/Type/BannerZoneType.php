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

namespace Elcodi\AdminBannerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class BannerZoneType
 */
class BannerZoneType extends AbstractType
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
            ->add('name', 'text', array(
                'required' => false,
                'label'    => 'name',
            ))
            ->add('code', 'text', array(
                'required' => false,
                'label'    => 'code',
            ))
            ->add('height', 'integer', array(
                'required' => false,
                'label'    => 'height',
            ))
            ->add('width', 'integer', array(
                'required' => false,
                'label'    => 'width',
            ))
            ->add('language', 'entity', array(
                'class'    => 'Elcodi\Component\Core\Entity\Language',
                'required' => false,
                'label'    => 'language',
                'multiple' => false,
            ))
            ->add('banners', 'entity', array(
                'class'    => 'Elcodi\Component\Banner\Entity\Banner',
                'required' => false,
                'label'    => 'banners',
                'multiple' => false,
            ));
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_admin_banner_form_type_banner_zone';
    }
}
