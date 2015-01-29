<?php

/*
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

namespace Elcodi\Admin\PageBundle\Form\Type;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Elcodi\Admin\PageBundle\Form\EventListener\PermanentPageSubscriber;
use Elcodi\Component\EntityTranslator\EventListener\Traits\EntityTranslatableFormTrait;

/**
 * Class PageType
 */
class PageType extends AbstractType
{
    use EntityTranslatableFormTrait;

    /**
     * A permanent page form event subscriber.
     *
     * @var EventSubscriberInterface
     */
    protected $permanentPageSubscriber;

    /**
     * Builds the page edit form.
     *
     * @param EventSubscriberInterface $permanentPageSubscriber A permanent page event subscriber.
     */
    public function __construct(EventSubscriberInterface $permanentPageSubscriber)
    {
        $this->permanentPageSubscriber = $permanentPageSubscriber;
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
            ->add('title', 'text', [
                'required' => true,
                'label'    => 'title',
            ])
            ->add('path', 'text', [
                'required' => true,
                'label'    => 'path',
            ])
            ->add('content', 'textarea', [
                'required' => true,
                'label'    => 'content',
            ])
            ->add('metaTitle', 'text', [
                'required' => false,
                'label'    => 'Metatitle',
            ])
            ->add('metaDescription', 'text', [
                'required' => false,
                'label'    => 'Metadescription',
            ])
            ->add('metaKeywords', 'text', [
                'required' => false,
                'label'    => 'Metakeywords',
            ])
            ->add('enabled', 'checkbox', [
                'required' => false,
                'label'    => 'enabled',
            ])
        ;

        $builder->addEventSubscriber($this->getEntityTranslatorFormEventListener());
        $builder->addEventSubscriber($this->permanentPageSubscriber);
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
