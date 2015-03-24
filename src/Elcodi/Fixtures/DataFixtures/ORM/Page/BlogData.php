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
 * Class BlogData
 */
class BlogData extends AbstractFixture
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
         * Blog post hello
         */
        $blogPostContent = <<<OEF
Hola amigos.

Nuestra más humilde bienvenida a nuestro blog.

En este blog encontrarás las últimas novedades, así como todas las noticias relacionadas con nuestra tienda.

No dudéis en dejar vuestros comentarios e impresiones, así como sugerencias y opiniones. Éstos nos serán de extrema ayuda para mejorar nuestro producto y poder seguir trabajando para darle un mejor servicio cada dia.

Salutaciones y esperamos verle de nuevo.
OEF;

        $blogPostHello = $pageFactory
            ->create()
            ->setTitle('Hola mundo')
            ->setPath('hola-mundo')
            ->setContent($blogPostContent)
            ->setType(ElcodiPageTypes::TYPE_BLOG_POST)
            ->setEnabled(true);

        $pageObjectManager->persist($blogPostHello);
        $this->addReference('blog_post-hello', $blogPostHello);
        $pageObjectManager->flush($blogPostHello);

        $entityTranslator->save($blogPostHello, [
            'es' => [
                'title'   => 'Hola mundo',
                'path'    => 'hola-mundo',
                'content' => $blogPostContent,
            ],
        ]);
    }
}
