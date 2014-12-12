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

namespace Elcodi\AdminConfigurationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ConfigurationType
 */
class ConfigurationType extends AbstractType
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
            ->add('namespace', 'text', array(
                'required' => false,
                'label'    => 'namespace',
            ))
            ->add('parameter', 'text', array(
                'required' => true,
                'label'    => 'parameter',
            ))
            ->add('value', 'text', array(
                'required' => true,
                'label'    => 'value',
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
        return 'elcodi_admin_configuration_form_type_configuration';
    }
}
