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
 * @author Maksim Karpychev <kodermax@gmail.com>
 */

namespace Elcodi\Plugin\ClearCacheBundle\Templating;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\EventDispatcher\Interfaces\EventInterface;
use Elcodi\Component\Plugin\Templating\Traits\TemplatingTrait;

class TwigRenderer
{
    use TemplatingTrait;
    /**
     * @var Plugin
     *
     */
    protected $plugin;

    /**
     * Set plugin
     *
     * @param Plugin $plugin Plugin
     *
     * @return $this Self object
     */
    public function setPlugin(Plugin $plugin)
    {
        $this->plugin = $plugin;

        return $this;
    }

    /**
     * Renders disqus JS element
     *
     * @param EventInterface $event Event
     */
    public function renderJavascript(EventInterface $event)
    {
        $this->appendTemplate(
                '@ElcodiClearCache/js.html.twig',
                $event,
                $this->plugin
            );
    }
}
