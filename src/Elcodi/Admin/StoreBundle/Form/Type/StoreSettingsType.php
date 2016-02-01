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

namespace Elcodi\Admin\StoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ArrayChoiceList;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;
use Elcodi\Component\Store\StoreRoutingStrategy;

/**
 * Class StoreSettingsType
 */
class StoreSettingsType extends AbstractType
{
    use FactoryTrait;

    /**
     * @var string
     *
     * Currency namespace
     */
    protected $currencyNamespace;

    /**
     * @var string
     *
     * Language namespace
     */
    protected $languageNamespace;

    /**
     * Construct
     *
     * @param string $currencyNamespace Currency namespace
     * @param string $languageNamespace Language namespace
     */
    public function __construct(
        $currencyNamespace,
        $languageNamespace
    ) {
        $this->currencyNamespace = $currencyNamespace;
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
            ->add('useStock', 'checkbox', [
                'required' => false,
            ])
            ->add('routingStrategy', 'choice', [
                'choice_list' => new ArrayChoiceList([
                    'admin.store.field.routingStrategy.prefix_except_default' => StoreRoutingStrategy::STRATEGY_PREFIX_EXCEPT_DEFAULT,
                    'admin.store.field.routingStrategy.prefix'                => StoreRoutingStrategy::STRATEGY_PREFIX,
                    'admin.store.field.routingStrategy.custom'                => StoreRoutingStrategy::STRATEGY_CUSTOM,
                ]),
                'required'    => true,
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
        return 'elcodi_admin_store_form_type_store_settings';
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
