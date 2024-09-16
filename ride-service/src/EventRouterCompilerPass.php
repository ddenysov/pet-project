<?php

namespace Ride;

use Common\Application\EventStore\EventRouter;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class EventRouterCompilerPass implements CompilerPassInterface
{
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