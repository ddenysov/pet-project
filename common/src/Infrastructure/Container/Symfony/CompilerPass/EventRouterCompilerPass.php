<?php

namespace Common\Infrastructure\Container\Symfony\CompilerPass;

use Common\Application\EventStore\EventRouter;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EventRouterCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition(EventRouter::class);

        $definitions = $container->findTaggedServiceIds('event.domain_event');

        foreach ($definitions as $event => $params) {
            $definition->addMethodCall('registerChannel', [$event, $params[0]['channel']]);
            $definition->addMethodCall('registerTransport', [$event, $params[0]['transport']]);
        }
    }

}