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

namespace Elcodi\AdminMediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ImageType
 */
class ImageType extends AbstractType
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
            ->add('contentType', 'text', array(
                'required' => false,
                'label'    => 'contentType',
            ))
            ->add('extension', 'text', array(
                'required' => false,
                'label'    => 'extension',
            ))
            ->add('size', 'integer', array(
                'required' => false,
                'label'    => 'size',
            ))
            ->add('width', 'integer', array(
                'required' => false,
                'label'    => 'width',
            ))
            ->add('height', 'integer', array(
                'required' => false,
                'label'    => 'height',
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
            ));
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_admin_media_form_type_image';
    }
}
