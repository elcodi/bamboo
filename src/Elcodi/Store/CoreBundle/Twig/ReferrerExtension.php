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

namespace Elcodi\Store\CoreBundle\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

use Elcodi\Component\Core\Services\ReferrerProvider;

/**
 * Class ReferrerExtension
 */
class ReferrerExtension extends Twig_Extension
{
    /**
     * @var ReferrerProvider
     *
     * Referrer provider
     */
    protected $referrerProvider;

    /**
     * Construct
     *
     * @param ReferrerProvider $referrerProvider Referrer Provider
     */
    public function __construct(ReferrerProvider $referrerProvider)
    {
        $this->referrerProvider = $referrerProvider;
    }

    /**
     * Return all functions
     *
     * @return Twig_SimpleFunction[] Functions
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('referrer', [$this, 'getReferrer']),
            new Twig_SimpleFunction('referrer_domain', [$this, 'getReferrerDomain']),
            new Twig_SimpleFunction('referrer_is_search_engine', [$this, 'referrerIsSearchEngine']),
        ];
    }

    /**
     * Return the referrer
     *
     * @return string Referrer name
     */
    public function getReferrer()
    {
        return $this
            ->referrerProvider
            ->getReferrer();
    }

    /**
     * Return the referrer domain
     *
     * @return string Referrer domain name
     */
    public function getReferrerDomain()
    {
        return $this
            ->referrerProvider
            ->getReferrerDomain();
    }

    /**
     * Return if the referrer is a search engine
     *
     * @return string Referrer is search engine
     */
    public function referrerIsSearchEngine()
    {
        return (int) $this
            ->referrerProvider
            ->referrerIsSearchEngine();
    }

    /**
     * return extension name
     *
     * @return string extension name
     */
    public function getName()
    {
        return 'referrer_extension';
    }
}
