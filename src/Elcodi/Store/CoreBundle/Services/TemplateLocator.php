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

namespace Elcodi\Store\CoreBundle\Services;

use Symfony\Component\Security\Core\Exception\RuntimeException;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class TemplateLocator
 */
class TemplateLocator
{
    /**
     * @var EngineInterface
     *
     * Render engine
     */
    private $engine;

    /**
     * @var array
     *
     * Bundles to search
     */
    private $bundles;

    /**
     * Constructs the template locator
     *
     * @param EngineInterface $engine  Render engine
     * @param array           $bundles The bundles to check (sorted).
     */
    public function __construct(
        EngineInterface $engine,
        array $bundles
    ) {
        $this->bundles = $bundles;
        $this->engine  = $engine;
    }

    /**
     * Search for the template in every specified bundle
     *
     * @param string $templatePath The template to find.
     *
     * @return string           The full template name.
     * @throws RuntimeException If the template is not found
     */
    public function locate($templatePath)
    {
        $template = $this
            ->findTemplate($templatePath);

        if (!$template) {
            throw new RuntimeException(sprintf(
                'Template "%s" not found in these Bundles: {%s}',
                $templatePath,
                implode(', ', $this->bundles)
            ));
        }

        return $template;
    }

    /**
     * Finds the template in all the bundles.
     *
     * @param string $templatePath The template to search.
     *
     * @return bool|string The string found or false if not found
     */
    protected function findTemplate($templatePath)
    {
        foreach ($this->bundles as $bundleName) {
            $templateName = "{$bundleName}:{$templatePath}";

            if ($this->engine->exists($templateName)) {
                return $templateName;
            }
        }

        return false;
    }
}
