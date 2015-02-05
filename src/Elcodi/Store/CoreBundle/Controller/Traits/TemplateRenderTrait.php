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

namespace Elcodi\Store\CoreBundle\Controller\Traits;

/**
 * Trait TemplateRenderTrait
 */
trait TemplateRenderTrait
{
    /**
     * Render a template with preloaded template
     *
     * @param string $path  Template path without bundle
     * @param array  $param Params
     *
     * @return \Symfony\Component\HttpFoundation\Response Response
     */
    protected function renderTemplate($path, $param = [])
    {
        $templateBundle = $this
            ->get('elcodi.configuration_manager')
            ->get('store.template');

        return $this
            ->render(
                $templateBundle.':'.$path,
                $param
            );
    }
}
