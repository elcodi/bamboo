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

namespace Elcodi\Admin\PageBundle\Form\Type;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;
use Elcodi\Component\EntityTranslator\EventListener\Traits\EntityTranslatableFormTrait;
use Elcodi\Component\Page\ElcodiPageTypes;

/**
 * Class PageType
 */
class PageType extends AbstractType
{
    use EntityTranslatableFormTrait, FactoryTrait;

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
            ->add('title', 'text', [
                'required' => true,
            ])
            ->add('path', 'text', [
                'required' => true,
            ])
            ->add('type', 'hidden', [
                'required' => true,
                'data'     => ElcodiPageTypes::TYPE_REGULAR,
            ])
            ->add('content', 'textarea', [
                'required' => true,
            ])
            ->add('metaTitle', 'text', [
                'required' => false,
            ])
            ->add('metaDescription', 'text', [
                'required' => false,
            ])
            ->add('metaKeywords', 'text', [
                'required' => false,
            ])
            ->add('enabled', 'checkbox', [
                'required' => false,
            ]);

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
        return 'elcodi_admin_form_type_page';
    }
}
