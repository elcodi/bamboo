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

namespace Elcodi\Admin\ShippingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Elcodi\Component\EntityTranslator\EventListener\Traits\EntityTranslatableFormTrait;

/**
 * Class CarrierType
 */
class CarrierType extends AbstractType
{
    use EntityTranslatableFormTrait;

    /**
     * @var string
     *
     * tax namespace
     */
    protected $taxNamespace;

    /**
     * Construct
     *
     * @param string $taxNamespace tax namespace
     */
    public function __construct($taxNamespace)
    {
        $this->taxNamespace = $taxNamespace;
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
            ->add('name', 'text', array(
                'required' => true,
            ))
            ->add('description', 'text', array(
                'required' => true,
            ))
            ->add('tax', 'entity', array(
                'class'    => $this->taxNamespace,
                'required' => true,
                'property' => 'name',
                'multiple' => false,
            ))
            ->add('enabled', 'checkbox', array(
                'required' => false,
            ));

        $builder->addEventSubscriber($this->getEntityTranslatorFormEventListener());
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_admin_shipping_form_type_carrier';
    }
}
