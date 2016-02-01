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

namespace Elcodi\Plugin\StoreSetupWizardBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\Services\PluginManager;
use Elcodi\Component\Store\Entity\Interfaces\StoreInterface;
use Elcodi\Plugin\StoreSetupWizardBundle\Services\WizardStatus;

/**
 * Class DisableWizardEventListener
 */
class DisableWizardEventListener
{
    /**
     * @var Plugin
     *
     * Plugin
     */
    protected $plugin;

    /**
     * @var WizardStatus
     *
     * A wizard status service.
     */
    protected $wizardStatus;

    /**
     * @var PluginManager
     *
     * A plugin manager service.
     */
    protected $pluginManager;

    /**
     * @var StoreInterface
     *
     * Store
     */
    protected $store;

    /**
     * @var ObjectManager
     *
     * Plugin object manager
     */
    protected $pluginObjectManager;

    /**
     * Builds a new class
     *
     * @param WizardStatus   $wizardStatus        A wizard status service
     * @param PluginManager  $pluginManager       A plugin manager
     * @param ObjectManager  $pluginObjectManager Plugin object manager
     * @param StoreInterface $store               Store
     */
    public function __construct(
        WizardStatus $wizardStatus,
        PluginManager $pluginManager,
        ObjectManager $pluginObjectManager,
        StoreInterface $store
    ) {
        $this->wizardStatus = $wizardStatus;
        $this->pluginManager = $pluginManager;
        $this->pluginObjectManager = $pluginObjectManager;
        $this->store = $store;
    }

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
     * Checks if the plugin should be disabled
     *
     * @param GetResponseEvent $event The response event
     */
    public function handle(GetResponseEvent $event)
    {
        if (
            $this->plugin->isEnabled() &&
            $this->wizardStatus->isWizardFinished()
        ) {
            $this
                ->plugin
                ->setEnabled(false);

            $this
                ->pluginObjectManager
                ->flush($this->plugin);
        }
    }
}
