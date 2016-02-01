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

namespace Elcodi\Store\PageBundle\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

use Elcodi\Component\Page\ElcodiPageTypes;
use Elcodi\Component\Page\Repository\PageRepository;

/**
 * Class PageExtension
 */
class PageExtension extends Twig_Extension
{
    /**
     * @var PageRepository
     *
     * Page Repository
     */
    private $pageRepository;

    /**
     * Construct
     *
     * @param PageRepository $pageRepository Page Repository
     */
    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;

        return $this;
    }

    /**
     * Return all functions
     *
     * @return Twig_SimpleFunction[] Functions
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('elcodi_footer_pages', [$this, 'getFooterPages']),
            new Twig_SimpleFunction('elcodi_blog_pages', [$this, 'getBlogPages']),
        ];
    }

    /**
     * Get footer pages
     *
     * @return array Collection of enabled pages for the footer
     */
    public function getFooterPages()
    {
        return $this
            ->pageRepository
            ->findBy([
                'enabled' => true,
                'type'    => ElcodiPageTypes::TYPE_REGULAR,
            ]);
    }

    /**
     * Get blog pages
     *
     * @param integer $page          Page
     * @param integer $numberPerPage Number per page
     *
     * @return array Collection of enabled pages for the blog
     */
    public function getBlogPages($page = 1, $numberPerPage = 10)
    {
        return $this
            ->pageRepository
            ->findPages(
                ElcodiPageTypes::TYPE_BLOG_POST,
                $page,
                $numberPerPage
            );
    }

    /**
     * return extension name
     *
     * @return string extension name
     */
    public function getName()
    {
        return 'store_page_extension';
    }
}
