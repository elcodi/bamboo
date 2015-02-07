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

namespace Elcodi\Store\CoreBundle\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class FirewallListenerCompilerPass
 *
 * @author Berny Cantos <be@rny.cc>
 */
class FirewallListenerCompilerPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    protected $tagName;

    /**
     * @param string $tagName
     */
    public function __construct($tagName = 'firewall_listener')
    {
        $this->tagName = $tagName;
    }

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

        $listenersByContext = $this->collectListenersByProviderKey($container);

        foreach ($listenersByContext as $providerKey => $listenersByType) {
            if (isset($listenersByType['event'])) {
                $listenerId = $this->attachEvents($container, $providerKey, $listenersByType['event']);
                $listenersByType['firewall'][0][] = new Reference($listenerId);
            }

            if (isset($listenersByType['firewall'])) {
                $this->attachListeners($container, $providerKey, $listenersByType['firewall']);
            }
        }
    }

    /**
     * Sort listeners by priority and then attach them to the firewall
     *
     * @param ContainerBuilder $container
     * @param string           $providerKey
     *
     * @param array $listeners
     */
    protected function attachListeners(ContainerBuilder $container, $providerKey, array $listeners)
    {
        krsort($listeners);
        $listeners = call_user_func_array('array_merge', $listeners);
        $contextId = 'security.firewall.map.context.'.$providerKey;

        $definition = $container->findDefinition($contextId);

        $argument = $definition->getArgument(0);
        $argument = array_merge($argument, $listeners);
        $definition->replaceArgument(0, $argument);
    }

    /**
     * Add event listeners to be attached by demand on firewall activation
     *
     * @param ContainerBuilder $container
     * @param string           $provider_key
     * @param array            $events
     *
     * @return string
     */
    protected function attachEvents(ContainerBuilder $container, $provider_key, array $events)
    {
        $listenerId = 'elcodi.security.firewall.listener.'.$provider_key;

        $definition = new DefinitionDecorator('elcodi.security.firewall.abstract_listener');
        $definition->replaceArgument(1, $events);
        $container->setDefinition($listenerId, $definition);

        return $listenerId;
    }

    /**
     * @param ContainerBuilder $container
     *
     * @return array
     */
    protected function collectListenersByProviderKey(ContainerBuilder $container)
    {
        $providerKeys = array();

        $taggedListeners = $container->findTaggedServiceIds($this->tagName);
        foreach ($taggedListeners as $listenerId => $tags) {
            foreach ($tags as $tag) {
                $providerKey = $this->getProviderKey($container, $tag, $listenerId);
                $priority = isset($tag['priority']) ? $tag['priority'] : 0;

                if (isset($tag['event'])) {
                    $listener = $this->processEvent($container, $listenerId, $tag, $priority);
                    $providerKeys[$providerKey]['event'][] = $listener;
                } elseif (isset($tag['method'])) {
                    throw new \InvalidArgumentException(sprintf(
                        'The "method" attribute does nothing in "%s" tags if "event" is not set in "%s" definition.',
                        $this->tagName,
                        $listenerId
                    ));
                } else {
                    $providerKeys[$providerKey]['firewall'][$priority][] = new Reference($listenerId);
                }
            }
        }

        return $providerKeys;
    }

    /**
     * Get the firewall provider key from a tag attribute, if it can found one
     *
     * @param ContainerBuilder $container  Container to resolve parameters
     * @param array            $tag        Tag to search for the firewall key
     * @param string           $listenerId Name of the service
     *
     * @return string
     */
    protected function getProviderKey(ContainerBuilder $container, array $tag, $listenerId)
    {
        if (!isset($tag['firewall'])) {
            throw new \RuntimeException(sprintf(
                'Must define "firewall" or "context" in "%s" tag for %s.',
                $this->tagName,
                $listenerId
            ));
        }

        return $container
            ->getParameterBag()
            ->resolveValue($tag['firewall']);
    }

    /**
     * Process an event and generates injection for the listener
     *
     * @param ContainerBuilder $container
     * @param string           $listenerId
     * @param array            $tag
     * @param $priority
     *
     * @return array
     */
    private function processEvent($container, $listenerId, array $tag, $priority)
    {
        $definition = $container->getDefinition($listenerId);

        if (!$definition->isPublic()) {
            throw new \InvalidArgumentException(sprintf(
                'The service "%s" must be public as event listeners are lazy-loaded.',
                $listenerId
            ));
        }

        if ($definition->isAbstract()) {
            throw new \InvalidArgumentException(sprintf(
                'The service "%s" must not be abstract as event listeners are lazy-loaded.',
                $listenerId
            ));
        }

        if (!isset($tag['method'])) {
            $tag['method'] = 'on'.preg_replace_callback(array(
                    '/(?<=\b)[a-z]/i',
                    '/[^a-z0-9]/i',
                ), function ($matches) { return strtoupper($matches[0]); }, $tag['event']);

            $tag['method'] = preg_replace('/[^a-z0-9]/i', '', $tag['method']);
        }

        return array(
            'eventName' => $tag['event'],
            'callback' => array($listenerId, $tag['method']),
            'priority' => $priority,
        );
    }
}
