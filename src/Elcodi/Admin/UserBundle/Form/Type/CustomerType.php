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

namespace Elcodi\Admin\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;
use Elcodi\Component\User\ElcodiUserProperties;

/**
 * Class CustomerType
 */
class CustomerType extends AbstractType
{
    use FactoryTrait;

    /**
     * @var string
     *
     * Language namespace
     */
    protected $languageNamespace;

    /**
     * Construct
     *
     * @param string $languageNamespace Language Namespace
     */
    public function __construct($languageNamespace)
    {
        $this->languageNamespace = $languageNamespace;
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
            ->setMethod('POST')
            ->add('username', 'text', [
                'required' => true,
            ])
            ->add('email', 'email', [
                'required' => true,
            ])
            ->add('firstname', 'text', [
                'required' => true,
            ])
            ->add('lastname', 'text', [
                'required' => true,
            ])
            ->add('gender', 'choice', [
                'choices'  => [
                    ElcodiUserProperties::GENDER_MALE => 'admin.user.field.gender.options.male',
                    ElcodiUserProperties::GENDER_FEMALE => 'admin.user.field.gender.options.female',
                ],
                'required' => true,
            ])
            ->add('language', 'entity', [
                'class'    => $this->languageNamespace,
                'property' => 'name',
                'required' => true,
            ])
            ->add('birthday', 'date', [
                'required' => false,
                'widget'   => 'single_text',
                'format'   => 'yyyy-MM-dd',
            ])
            ->add('phone', 'text', [
                'required' => false,
            ])
            ->add('identityDocument', 'text', [
                'required' => false,
            ])
            ->add('guest', 'checkbox', [
                'required' => false,
            ])
            ->add('newsletter', 'checkbox', [
                'required' => false,
            ])
            ->add('enabled', 'checkbox', [
                'required' => false,
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
        return 'elcodi_admin_user_form_type_customer';
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
