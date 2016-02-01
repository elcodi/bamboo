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

namespace Elcodi\Admin\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;
use Elcodi\Component\EntityTranslator\EventListener\Traits\EntityTranslatableFormTrait;
use Elcodi\Component\Page\ElcodiPageTypes;

/**
 * Class BlogPostType
 */
class BlogPostType extends AbstractType
{
    use EntityTranslatableFormTrait, FactoryTrait;

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
            ->add('title', 'text', [
                'required' => true,
                'label'    => 'title',
            ])
            ->add('path', 'text', [
                'required' => true,
                'label'    => 'path',
            ])
            ->add('type', 'hidden', [
                'required' => true,
                'data'     => ElcodiPageTypes::TYPE_BLOG_POST,
            ])
            ->add('content', 'textarea', [
                'required' => true,
                'label'    => 'content',
            ])
            ->add('publicationDate', 'date', [
                'required' => true,
                'widget'   => 'single_text',
                'format'   => 'yyyy-MM-dd',
                'label'    => 'Publication Date',
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
            ]);

        $builder->addEventSubscriber($this->getEntityTranslatorFormEventListener());
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
        return 'elcodi_admin_page_form_type_blog_post';
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
