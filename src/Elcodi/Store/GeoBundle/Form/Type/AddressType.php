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

namespace Elcodi\Store\GeoBundle\Form\Type;

use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Callback as AssertCallback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\geo\Factory\AddressFactory;
use Elcodi\Component\Geo\Services\Interfaces\LocationProviderInterface;
use Elcodi\Component\Geo\ValueObject\LocationData;

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
     * @var LocationProviderInterface
     *
     * Location provider
     */
    private $locationProvider;

    /**
     * Constructor
     *
     * @param AddressFactory            $addressFactory   Address factory
     * @param LocationProviderInterface $locationProvider Location provider
     */
    public function __construct(
        AddressFactory $addressFactory,
        LocationProviderInterface $locationProvider
    ) {
        $this->addressFactory = $addressFactory;
        $this->locationProvider = $locationProvider;
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
            'data_class'  => $this->addressFactory->getEntityNamespace(),
            'empty_data'  => $this->addressFactory->create(),
            'constraints' => [
                new AssertCallback([[$this, 'validateCityExists']]),
            ],
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
            ->add('city', 'hidden', [
                'required' => true,
            ])
            ->add('name', 'text', [
                'required' => true,
                'label'    => 'Address name',
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
                'label'    => 'Address more (optional)',
            ])
            ->add('postalcode', 'text', [
                'required' => true,
                'label'    => 'Postalcode',
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
            ])
            ->add('send', 'submit', array(
                'label' => 'Save address',
            ));
    }

    /**
     * Validate city exists.
     *
     * @param AddressInterface          $object  The address edited
     * @param ExecutionContextInterface $context the execution context
     */
    public function validateCityExists(
        AddressInterface $object,
        ExecutionContextInterface $context
    ) {
        /**
         * @var LocationData $location
         */
        try {
            $location = $this->locationProvider->getLocation(
                $object->getCity()
            );
        } catch (EntityNotFoundException $e) {
            $location = null;
        }

        if (
            empty($location) ||
            'city' != $location->getType()
        ) {
            $context
                ->buildViolation('Select a city')
                ->atPath('city')
                ->addViolation();
        }
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
