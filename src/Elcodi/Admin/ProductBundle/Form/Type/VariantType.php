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

namespace Elcodi\Admin\ProductBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Elcodi\Admin\ProductBundle\Validation\MinimumMoney;
use Elcodi\Component\Attribute\Repository\ValueRepository;
use Elcodi\Component\Core\Factory\Traits\FactoryTrait;

/**
 * Class ProductType
 */
class VariantType extends AbstractType
{
    use FactoryTrait;

    /**
     * @var string
     *
     * Attribute Value namespace
     */
    protected $attributeValueNamespace;

    /**
     * @var string
     *
     * Image namespace
     */
    protected $imageNamespace;

    /**
     * Construct
     *
     * @param string $attributeValueNamespace Attribute Value namespace
     * @param string $imageNamespace          Image namespace
     */
    public function __construct($attributeValueNamespace, $imageNamespace)
    {
        $this->attributeValueNamespace = $attributeValueNamespace;
        $this->imageNamespace = $imageNamespace;
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
            ->add('options', 'entity', [
                'class'         => $this->attributeValueNamespace,
                'required'      => true,
                'multiple'      => true,
                'group_by'      => 'attribute',
                'query_builder' => function (ValueRepository $valueRepository) {
                    return $valueRepository
                        ->createQueryBuilder('v')
                        ->join('v.attribute', 'a');
                },
                'property'      => 'value',
            ])
            ->add('imagesSort', 'text', [
                'required' => false,
            ])
            ->add('images', 'entity', [
                'class'    => $this->imageNamespace,
                'required' => false,
                'property' => 'id',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('stock', 'number', [
                'required' => false,
            ])
            ->add('price', 'money_object', [
                'required' => false,
                'constraints' => [
                    new MinimumMoney([
                        'value' => 0,
                    ]),
                ],
            ])
            ->add('reducedPrice', 'money_object', [
                'required' => false,
                'constraints' => [
                    new MinimumMoney([
                        'value' => 0,
                    ]),
                ],
            ])
            ->add('enabled', 'checkbox', [
                'required' => false,
            ]);
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_admin_form_type_product_variant';
    }
}
