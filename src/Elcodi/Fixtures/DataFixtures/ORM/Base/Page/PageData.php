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

namespace Elcodi\Fixtures\DataFixtures\ORM\Base\Page;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslatorInterface;
use Elcodi\Component\Page\ElcodiPageTypes;

/**
 * Class PageData
 */
class PageData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectDirector $pageDirector
         * @var EntityTranslatorInterface $entityTranslator
         */
        $pageDirector = $this->get('elcodi.director.page');
        $entityTranslator = $this->get('elcodi.entity_translator');

        /**
         * Blog post hello
         */
        $blogPostContent = <<<OEF
Hola amigos.

Nuestra más humilde bienvenida a nuestro blog.

En este blog encontrarás las últimas novedades, así como todas las noticias relacionadas con nuestra tienda.

No dudéis en dejar vuestros comentarios e impresiones, así como sugerencias y opiniones. Éstos nos serán de extrema ayuda para mejorar nuestro producto y poder seguir trabajando para darle un mejor servicio cada dia.

Salutaciones y esperamos verle de nuevo.
OEF;

        $blogPostHello = $pageDirector
            ->create()
            ->setTitle('Hola mundo')
            ->setPath('hola-mundo')
            ->setContent($blogPostContent)
            ->setType(ElcodiPageTypes::TYPE_BLOG_POST)
            ->setEnabled(true);

        $pageDirector->save($blogPostHello);
        $this->addReference('blog_post-hello', $blogPostHello);

        $entityTranslator->save($blogPostHello, [
            'es' => [
                'title'   => 'Hola mundo',
                'path'    => 'hola-mundo',
                'content' => $blogPostContent,
            ],
        ]);

        /**
         * About-us page
         */
        $aboutUsPage = $pageDirector
            ->create()
            ->setTitle('Sobre nosotros')
            ->setPath('sobre-nosotros')
            ->setContent('<li>Sobre nosotros</li>')
            ->setMetaTitle('Sobre nosotros')
            ->setMetaDescription('Sobre nosotros')
            ->setMetaKeywords('sobre,nosotros')
            ->setType(ElcodiPageTypes::TYPE_REGULAR)
            ->setEnabled(true)
            ->setPersistent(false);

        $this->addReference('page-about-us', $aboutUsPage);
        $pageDirector->save($aboutUsPage);

        $entityTranslator->save($aboutUsPage, [
            'en' => [
                'path' => 'about-us',
                'title' => 'About us',
                'content' => '<li>About us</li>',
                'metaTitle' => 'About us',
                'metaDescription' => 'About us',
                'metaKeywords' => 'about,us',
            ],
            'es' => [
                'path' => 'sobre-nosotros',
                'title' => 'Sobre nosotros',
                'content' => '<li>Sobre nosotros</li>',
                'metaTitle' => 'Sobre nosotros',
                'metaDescription' => 'Sobre nosotros',
                'metaKeywords' => 'sobre,nosotros',
            ],
            'fr' => [
                'path' => 'a-propos',
                'title' => 'A propos',
                'content' => '<li>A propos</li>',
                'metaTitle' => 'A propos',
                'metaDescription' => 'A propos',
                'metaKeywords' => 'propos',
            ],
            'ca' => [
                'path' => 'sobre-nosaltres',
                'title' => 'Sobre nosaltres',
                'content' => '<li>Sobre nosaltres</li>',
                'metaTitle' => 'Sobre nosaltres',
                'metaDescription' => 'Sobre nosaltres',
                'metaKeywords' => 'sobre,nosaltres',
            ],
        ]);

        /**
         * Terms and conditions page
         */
        $termsConditionsPage = $pageDirector
            ->create()
            ->setTitle('Términos y condiciones')
            ->setPath('terminos-y-condiciones')
            ->setContent('<li>Términos y condiciones</li>')
            ->setMetaTitle('Términos y condiciones')
            ->setMetaDescription('Términos y condiciones')
            ->setMetaKeywords('términos,condiciones')
            ->setType(ElcodiPageTypes::TYPE_REGULAR)
            ->setEnabled(true)
            ->setPersistent(false);

        $pageDirector->save($termsConditionsPage);
        $this->addReference('page-terms-and-conditions', $termsConditionsPage);

        $entityTranslator->save($termsConditionsPage, [
            'en' => [
                'path' => 'terms-and-conditions',
                'title' => 'Terms and conditions',
                'content' => '<li>Terms and conditions</li>',
                'metaTitle' => 'Terms and conditions',
                'metaDescription' => 'Terms and conditions',
                'metaKeywords' => 'terms,conditions',
            ],
            'es' => [
                'path' => 'terminos-y-condiciones',
                'title' => 'Términos y condiciones',
                'content' => '<li>Términos y condiciones</li>',
                'metaTitle' => 'Términos y condiciones',
                'metaDescription' => 'Términos y condiciones',
                'metaKeywords' => 'términos,condiciones',
            ],
            'fr' => [
                'path' => 'mentions-legales',
                'title' => 'Mentions legales',
                'content' => '<li>Mentions legales</li>',
                'metaTitle' => 'Mentions legales',
                'metaDescription' => 'Mentions legales',
                'metaKeywords' => 'mentions,legales',
            ],
            'ca' => [
                'path' => 'termes-legals',
                'title' => 'Termes legals',
                'content' => '<li>Termes legals</li>',
                'metaTitle' => 'Termes legals',
                'metaDescription' => 'Termes legals',
                'metaKeywords' => 'termes,legals',
            ],
        ]);

        /**
         * Order confirmation email
         */
        $orderConfirmationEmail = $pageDirector
            ->create()
            ->setTitle('Confirmación de pedido')
            ->setContent('Pedido confirmado para {{ customer.fullname }}.')
            ->setName('order_confirmation')
            ->setType(ElcodiPageTypes::TYPE_EMAIL)
            ->setEnabled(true)
            ->setPersistent(true);

        $pageDirector->save($orderConfirmationEmail);
        $this->addReference('email-order-confirmation', $orderConfirmationEmail);

        $entityTranslator->save($orderConfirmationEmail, [
            'es' => [
                'title'   => 'Confirmación de pedido',
                'content' => 'Pedido confirmado para {{ order.customer.fullname }}.',
            ],
        ]);

        /**
         * Order shipped email
         */
        $orderShippedEmail = $pageDirector
            ->create()
            ->setTitle('Aviso de envío de pedido para el cliente')
            ->setContent('Hola {{ customer.fullname }}. Su pedido acaba de ser mandado.')
            ->setName('order_shipped')
            ->setType(ElcodiPageTypes::TYPE_EMAIL)
            ->setEnabled(true)
            ->setPersistent(true);

        $pageDirector->save($orderShippedEmail);
        $this->addReference('email-order-shipped', $orderShippedEmail);

        $entityTranslator->save($orderShippedEmail, [
            'es' => [
                'title'   => 'Aviso de envío de pedido para el cliente',
                'content' => 'Hola {{ customer.fullname }}. Su pedido acaba de ser mandado.',
            ],
        ]);

        /**
         * Customer registration email
         */
        $customerRegistrationEmail = $pageDirector
            ->create()
            ->setTitle('Bienvenido!')
            ->setContent('Hola {{ customer.fullname }}. Le damos la Bienvenida.')
            ->setName('customer_registration')
            ->setType(ElcodiPageTypes::TYPE_EMAIL)
            ->setEnabled(true)
            ->setPersistent(true);

        $pageDirector->save($customerRegistrationEmail);
        $this->addReference('email-customer-registration', $customerRegistrationEmail);

        $entityTranslator->save($customerRegistrationEmail, [
            'es' => [
                'title'   => 'Bienvenido!',
                'content' => 'Hola {{ customer.fullname }}.  Le damos la Bienvenida.',
            ],
        ]);

        /**
         * Customer password remember
         */
        $passwordRememberEmail = $pageDirector
            ->create()
            ->setTitle('Recordatorio de contraseña')
            ->setContent('Hola {{ customer.fullname }}. Para recuperar tu contraseña entra en <a href="{{ remember_url }}">este enlace</a>.')
            ->setName('password_remember')
            ->setType(ElcodiPageTypes::TYPE_EMAIL)
            ->setEnabled(true)
            ->setPersistent(true);

        $pageDirector->save($passwordRememberEmail);
        $this->addReference('email-password-remember', $passwordRememberEmail);

        $entityTranslator->save($passwordRememberEmail, [
            'es' => [
                'title'   => 'Recordatorio de contraseña',
                'content' => 'Hola {{ customer.fullname }}. Para recuperar tu contraseña entra en <a href="{{ remember_url }}">este enlace</a>.',
            ],
        ]);

        /**
         * Customer password recover
         */
        $passwordRecoverEmail = $pageDirector
            ->create()
            ->setTitle('Contraseña recuperada')
            ->setContent('Hola {{ customer.fullname }}. Tu contraseña ha sido recuperada.')
            ->setName('password_recover')
            ->setType(ElcodiPageTypes::TYPE_EMAIL)
            ->setEnabled(true)
            ->setPersistent(true);

        $pageDirector->save($passwordRecoverEmail);
        $this->addReference('email-password-recover', $passwordRecoverEmail);

        $entityTranslator->save($passwordRecoverEmail, [
            'es' => [
                'title'   => 'Contraseña recuperada',
                'content' => 'Hola {{ customer.fullname }}. Tu contraseña ha sido recuperada.',
            ],
        ]);
    }
}
