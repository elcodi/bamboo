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

namespace Elcodi\Store\CoreBundle\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class FirewallListenerCompilerPass
 *
 * @author Berny Cantos <be@rny.cc>
 */
class FirewallListenerCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('security.firewall.context')) {
            return;
        }

        $listenersByContext = $this->collectListenersByContext($container);

        foreach ($listenersByContext as $context_id => $listeners) {
            $context_definition = $container->findDefinition($context_id);

            $arguments = $context_definition->getArgument(0);
            $arguments = array_merge($arguments, $listeners);
            $context_definition->replaceArgument(0, $arguments);
        }
    }

    /**
     * @param ContainerBuilder $container
     *
     * @return array
     */
    protected function collectListenersByContext(ContainerBuilder $container)
    {
        $listenersByContext = array();
        $taggedListeners = $container->findTaggedServiceIds('firewall_listener');
        foreach ($taggedListeners as $listener_id => $tags) {
            foreach ($tags as $tag) {

                $firewall_id = $this->getFirewallId($tag, $container);
                if (null === $firewall_id) {
                    throw new \RuntimeException(sprintf(
                        'Must define "firewall" or "context" in "firewall_listener" tag for %s.',
                        $listener_id
                    ));
                }

                $context_id = 'security.firewall.map.context.' . $firewall_id;
                if (!$container->has($context_id)) {
                    throw new \RuntimeException(sprintf(
                        'Context for firewall "%s" can not be found in "%s" definition.',
                        $firewall_id,
                        $listener_id
                    ));
                }

                $listenersByContext[$context_id][] = new Reference($listener_id);
            }
        }

        return $listenersByContext;
    }

    /**
     * Get the firewall attribute from a tag if it can found one
     *
     * @param array            $tag       tag to search for the firewall key
     * @param ContainerBuilder $container container to resolve parameters
     *
     * @return string
     */
    protected function getFirewallId(array $tag, ContainerBuilder $container)
    {
        if (!isset($tag['firewall'])) {
            return null;
        }

        return $container
            ->getParameterBag()
            ->resolveValue($tag['firewall']);
    }
}
