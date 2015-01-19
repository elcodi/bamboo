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

namespace Elcodi\AdminPageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Elcodi\Component\EntityTranslator\EventListener\Traits\EntityTranslatableFormTrait;

/**
 * Class PageType
 */
class PageType extends AbstractType
{
    use EntityTranslatableFormTrait;

    /**
     * Buildform function
     *
     * @param FormBuilderInterface $builder the formBuilder
     * @param array                $options the options for this form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'required' => true,
                'label'    => 'title',
            ))
            ->add('path', 'text', array(
                'required' => true,
                'label'    => 'path',
            ))
            ->add('content', 'textarea', array(
                'required' => true,
                'label'    => 'content',
            ))
            ->add('metaTitle', 'text', array(
                'required' => false,
                'label'    => 'Metatitle',
            ))
            ->add('metaDescription', 'text', array(
                'required' => false,
                'label'    => 'Metadescription',
            ))
            ->add('metaKeywords', 'text', array(
                'required' => false,
                'label'    => 'Metakeywords',
            ))
            ->add('enabled', 'checkbox', array(
                'required' => false,
                'label'    => 'enabled',
            ))
        ;

        $builder->addEventSubscriber($this->getEntityTranslatorFormEventListener());
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_admin_page_form_type_page';
    }
}
