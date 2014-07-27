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

namespace Admin\AdminMenuBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class MenuType
 */
class MenuType extends AbstractType
{
    /**
     * @var string
     *
     * Menu namespace
     */
    protected $menuNamespace;

    /**
     * Constructor
     *
     * @param string $menuNamespace Menu names
     */
    public function __construct($menuNamespace)
    {
        $this->menuNamespace = $menuNamespace;
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
        $resolver->setDefaults(array(
            'data_class' => $this->menuNamespace,
        ));
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
            ->add('code', 'text', array(
                'required' => true,
                'label'    => 'Code',
            ))
            ->add('description', 'textarea', array(
                'required' => true,
                'label'    => 'Description',
            ))
            ->add('createdAt', 'datetime', array(
                'required' => true,
                'widget'   => 'single_text',
                'format'   => 'yyyy-MM-dd - HH:mm:ss',
                'label'    => 'Created At',
            ))
            ->add('updatedAt', 'datetime', array(
                'required' => true,
                'widget'   => 'single_text',
                'format'   => 'yyyy-MM-dd - HH:mm:ss',
                'label'    => 'Updated At'
            ))
            ->add('enabled', 'checkbox', array(
                'required' => false,
                'label'    => 'Enabled'
            ));
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'admin_menu_form_type_menu';
    }

}
