<?php



namespace Elcodi\StoreTemplateBundle;

use Elcodi\Bundle\BambooBundle\Interfaces\TemplateBundleInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class StoreTemplateBundle
 */
class StoreTemplateBundle extends Bundle implements TemplateBundleInterface
{
    /**
     * Get the template bundle
     *
     * @return string Template name
     */
    public function getTemplateName()
    {
        return 'store_template';
    }
}
