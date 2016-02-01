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

namespace Elcodi\Store\PageBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as AnnotationEntity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Elcodi\Component\Page\ElcodiPageTypes;
use Elcodi\Component\Page\Entity\Interfaces\PageInterface;
use Elcodi\Store\CoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Class BlogController
 *
 * @Route(
 *      path = "/blog"
 * )
 */
class BlogController extends Controller
{
    use TemplateRenderTrait;

    /**
     * List blog posts
     *
     * @Route(
     *      path = "/{page}",
     *      name = "store_blog_view",
     *      defaults = {
     *          "page" = 1,
     *      },
     *      requirements = {
     *          "page" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     */
    public function listBlogPostsAction($page)
    {
        $numberOfPosts = $this
            ->get('elcodi.repository.page')
            ->getNumberOfEnabledPages(ElcodiPageTypes::TYPE_BLOG_POST);

        $postsPerPage = $this
            ->container
            ->getParameter('store.page.blog_posts_per_page');

        $numberOfPages = ceil($numberOfPosts / $postsPerPage);

        $blogPosts = $this
            ->get('elcodi.repository.page')
            ->findPages(
                ElcodiPageTypes::TYPE_BLOG_POST,
                $page,
                $postsPerPage
            );

        return $this->renderTemplate(
            'Pages:blog-posts-list.html.twig',
            [
                'blog_posts'       => $blogPosts,
                'current_page'    => $page,
                'number_of_pages' => $numberOfPages,
            ]
        );
    }

    /**
     * View blog post
     *
     * @Route(
     *      path = "/{id}/{slug}",
     *      name = "store_blog_post_view",
     *      methods = {"GET"}
     * )
     *
     * @AnnotationEntity(
     *      class = "elcodi.entity.page.class",
     *      name = "blogPost",
     *      mapping = {
     *          "id" = "~id~",
     *          "enabled" = true,
     *      }
     * )
     */
    public function viewBlogPostAction(PageInterface $blogPost, $slug)
    {
        if (ElcodiPageTypes::TYPE_BLOG_POST !== $blogPost->getType()) {
            $this->createNotFoundException();
        }

        /**
         * We must check that the product slug is right. Otherwise we must
         * return a Redirection 301 to the right url
         */
        if ($slug !== $blogPost->getPath()) {
            return $this->redirectToRoute('store_blog_post_view', [
                'id'   => $blogPost->getId(),
                'slug' => $blogPost->getPath(),
            ]);
        }

        return $this->renderTemplate(
            'Pages:blog-post-view.html.twig',
            [
                'blog_post' => $blogPost,
            ]
        );
    }
}
