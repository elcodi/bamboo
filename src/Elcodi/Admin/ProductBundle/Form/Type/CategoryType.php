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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Admin\ProductBundle\Form\Type;

use Elcodi\Component\Product\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Elcodi\Component\EntityTranslator\EventListener\Traits\EntityTranslatableFormTrait;
use Elcodi\Component\Product\Factory\CategoryFactory;
use Elcodi\Component\Product\Factory\ProductFactory;

/**
 * Class CategoryType
 */
class CategoryType extends AbstractType
{
    use EntityTranslatableFormTrait;

    /**
     * @var CategoryFactory
     *
     * Category factory
     */
    protected $categoryFactory;

    /**
     * @var ProductFactory
     *
     * Product factory
     */
    protected $productFactory;

    /**
     * Constructor
     *
     * @param CategoryFactory    $categoryFactory    Category Factory
     * @param ProductFactory     $productFactory     Product Factory
     */
    public function __construct(
        CategoryFactory $categoryFactory,
        ProductFactory $productFactory
    )
    {
        $this->categoryFactory = $categoryFactory;
        $this->productFactory = $productFactory;
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
            'empty_data' => $this->categoryFactory->create(),
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
        $currentCategoryId = $builder->getData()->getId();

        $builder
            ->add('name', 'text', [
                'required' => true,
                'label'    => 'name',
            ])
            ->add('slug', 'text', [
                'required' => false,
                'label'    => 'slug',
            ])
            ->add('root', 'checkbox', [
                'required' => false,
                'label'    => 'Root Category',
            ])
            ->add('enabled', 'checkbox', [
                'required' => false,
                'label'    => 'Visible',
            ])
            ->add('metaTitle', 'text', [
                'required' => false,
                'label'    => 'metaTitle',
            ])
            ->add('metaDescription', 'text', [
                'required' => false,
                'label'    => 'metaDescription',
            ])
            ->add('metaKeywords', 'text', [
                'required' => false,
                'label'    => 'metaKeywords',
            ])
            ->add('parent', 'entity', [
                'class'         => $this->categoryFactory->getEntityNamespace(),
                'query_builder' => $this->getAvailableCategories($currentCategoryId),
                'required'      => false,
                'label'         => 'parent',
                'multiple'      => false,
            ])
            ->add('products', 'entity', [
                'class'    => $this->productFactory->getEntityNamespace(),
                'required' => false,
                'label'    => false,
                'multiple' => true,
            ]);

        $builder->addEventSubscriber($this->getEntityTranslatorFormEventListener());
    }

    /**
     * This method returns a closure used to show only the valid categories to be selected as parent.
     *
     * @param integer|null $currentCategoryId The current category id
     *
     * @return callable
     */
    protected function getAvailableCategories($currentCategoryId)
    {
        return function (CategoryRepository $categoryRepository) use ($currentCategoryId) {
            $queryBuilder = $categoryRepository
                ->createQueryBuilder('c')
                ->where('c.root = 1');

            if ($currentCategoryId) {
                $queryBuilder
                    ->andWhere('c.id <> :parent_category')
                    ->setParameter('parent_category', $currentCategoryId);
            }

            return $queryBuilder;
        };
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_admin_product_form_type_category';
    }
}
