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

namespace Elcodi\Store\GeoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Elcodi\Component\geo\Factory\AddressFactory;

/**
 * Class AddressType
 */
class AddressType extends AbstractType
{
    /**
     * @var string
     *
     * Address factory
     */
    protected $addressFactory;

    /**
     * @var string
     *
     * Country namespace
     */
    protected $countryNamespace;

    /**
     * Constructor
     *
     * @param AddressFactory $addressFactory   Address factory
     * @param string         $countryNamespace Country namespace
     */
    public function __construct(
        AddressFactory $addressFactory,
        $countryNamespace
    )
    {
        $this->addressFactory = $addressFactory;
        $this->countryNamespace = $countryNamespace;
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
            'data_class' => $this->addressFactory->getEntityNamespace(),
            'empty_data' => $this->addressFactory->create(),
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
            ->add('name', 'text', [
                'required' => true,
                'label'    => 'Name',
            ])
            ->add('recipientName', 'text', [
                'required' => true,
                'label'    => 'Recipient name',
            ])
            ->add('recipientSurname', 'text', [
                'required' => true,
                'label'    => 'Recipient Surname',
            ])
            ->add('address', 'text', [
                'required' => true,
                'label'    => 'Address',
            ])
            ->add('addressMore', 'text', [
                'required' => false,
                'label'    => 'Address more',
            ])
            ->add('postalcode', 'text', [
                'required' => true,
                'label'    => 'Postalcode',
            ])
            ->add('city', 'text', [
                'required' => true,
                'label'    => 'City',
            ])
            ->add('province', 'text', [
                'required' => true,
                'label'    => 'Province',
            ])
            ->add('state', 'text', [
                'required' => true,
                'label'    => 'State',
            ])
            ->add('country', 'entity', [
                'class' => $this->countryNamespace,
                'required' => true,
                'label'    => 'Country',
                'property' => 'name',
            ])
            ->add('phone', 'text', [
                'required' => true,
                'label'    => 'Phone',
            ])
            ->add('mobile', 'text', [
                'required' => false,
                'label'    => 'Mobile',
            ])
            ->add('comments', 'textarea', [
                'required' => false,
                'label'    => 'Comments',
            ]);
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'store_geo_form_type_address';
    }
}
