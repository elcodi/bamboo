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

namespace Elcodi\Fixtures\DataFixtures\ORM\Page;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslatorInterface;
use Elcodi\Component\Page\ElcodiPageTypes;
use Elcodi\Component\Page\Factory\PageFactory;

/**
 * Class EmailData
 */
class EmailData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var PageFactory               $pageFactory
         * @var ObjectManager             $pageObjectManager
         * @var EntityTranslatorInterface $entityTranslator
         */
        $pageFactory = $this->get('elcodi.factory.page');
        $pageObjectManager = $this->get('elcodi.object_manager.page');
        $entityTranslator = $this->get('elcodi.entity_translator');

        /**
         * Order confirmation email
         */
        $orderConfirmationEmail = $pageFactory
            ->create()
            ->setTitle('Confirmación de pedido')
            ->setContent('Pedido confirmado para {{ customer.fullname }}.')
            ->setName('order_confirmation')
            ->setType(ElcodiPageTypes::TYPE_EMAIL)
            ->setEnabled(true)
            ->setPersistent(true);

        $pageObjectManager->persist($orderConfirmationEmail);
        $this->addReference('email-order-confirmation', $orderConfirmationEmail);
        $pageObjectManager->flush($orderConfirmationEmail);

        $entityTranslator->save($orderConfirmationEmail, [
            'es' => [
                'title'   => 'Confirmación de pedido',
                'content' => 'Pedido confirmado para {{ order.customer.fullname }}.',
            ],
        ]);

        /**
         * Order shipped email
         */
        $orderShippedEmail = $pageFactory
            ->create()
            ->setTitle('Aviso de envío de pedido para el cliente')
            ->setContent('Hola {{ customer.fullname }}. Su pedido acaba de ser mandado.')
            ->setName('order_shipped')
            ->setType(ElcodiPageTypes::TYPE_EMAIL)
            ->setEnabled(true)
            ->setPersistent(true);

        $pageObjectManager->persist($orderShippedEmail);
        $this->addReference('email-order-shipped', $orderShippedEmail);
        $pageObjectManager->flush($orderShippedEmail);

        $entityTranslator->save($orderShippedEmail, [
            'es' => [
                'title'   => 'Aviso de envío de pedido para el cliente',
                'content' => 'Hola {{ customer.fullname }}. Su pedido acaba de ser mandado.',
            ],
        ]);

        /**
         * Customer registration email
         */
        $customerRegistrationEmail = $pageFactory
            ->create()
            ->setTitle('Registro de nuevo usuario')
            ->setContent('Hola {{ customer.fullname }}. Le damos la Bienvenida.')
            ->setName('customer_registration')
            ->setType(ElcodiPageTypes::TYPE_EMAIL)
            ->setEnabled(true)
            ->setPersistent(true);

        $pageObjectManager->persist($customerRegistrationEmail);
        $this->addReference('email-customer-registration', $customerRegistrationEmail);
        $pageObjectManager->flush($customerRegistrationEmail);

        $entityTranslator->save($customerRegistrationEmail, [
            'es' => [
                'title'   => 'Confirmación de pedido',
                'content' => 'Hola {{ customer.fullname }}.  Le damos la Bienvenida.',
            ],
        ]);

        /**
         * Customer password remember
         */
        $passwordRememberEmail = $pageFactory
            ->create()
            ->setTitle('Recordatorio de contraseña')
            ->setContent('Hola {{ customer.fullname }}. Para recuperar tu contraseña entra en <a href="{{ remember_url }}">este enlace</a>.')
            ->setName('password_remember')
            ->setType(ElcodiPageTypes::TYPE_EMAIL)
            ->setEnabled(true)
            ->setPersistent(true);

        $pageObjectManager->persist($passwordRememberEmail);
        $this->addReference('email-password-remember', $passwordRememberEmail);
        $pageObjectManager->flush($passwordRememberEmail);

        $entityTranslator->save($passwordRememberEmail, [
            'es' => [
                'title'   => 'Recordatorio de contraseña',
                'content' => 'Hola {{ customer.fullname }}. Para recuperar tu contraseña entra en <a href="{{ remember_url }}">este enlace</a>.',
            ],
        ]);

        /**
         * Customer password recover
         */
        $passwordRecoverEmail = $pageFactory
            ->create()
            ->setTitle('Recordatorio de contraseña')
            ->setContent('Hola {{ customer.fullname }}. Tu contraseña ha sido recuperada.')
            ->setName('password_recover')
            ->setType(ElcodiPageTypes::TYPE_EMAIL)
            ->setEnabled(true)
            ->setPersistent(true);

        $pageObjectManager->persist($passwordRecoverEmail);
        $this->addReference('email-password-recover', $passwordRecoverEmail);
        $pageObjectManager->flush($passwordRecoverEmail);

        $entityTranslator->save($passwordRecoverEmail, [
            'es' => [
                'title'   => 'Recordatorio de contraseña',
                'content' => 'Hola {{ customer.fullname }}. Tu contraseña ha sido recuperada.',
            ],
        ]);
    }
}
