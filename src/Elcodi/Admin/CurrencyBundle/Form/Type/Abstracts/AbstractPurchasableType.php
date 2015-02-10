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

namespace Elcodi\Admin\CurrencyBundle\Form\Type\Abstracts;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

abstract class AbstractPurchasableType extends AbstractType
{
    /**
     * @var string
     *
     * Entity namespace
     */
    protected $entityNamespace;

    /**
     * @var AbstractFactory
     *
     * Variant factory
     */
    protected $purchasableFactory;

    /**
     * Construct method
     *
     * @param string          $entityNamespace    Entity namespace
     * @param AbstractFactory $purchasableFactory Factory for a purchasable entity
     */
    public function __construct(
        $entityNamespace,
        AbstractFactory $purchasableFactory
    )
    {
        $this->entityNamespace = $entityNamespace;
        $this->purchasableFactory = $purchasableFactory;
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
        $purchasable = $this->purchasableFactory->create();

        $resolver->setDefaults(array(
            'empty_data' => $purchasable
        ));
    }
}
