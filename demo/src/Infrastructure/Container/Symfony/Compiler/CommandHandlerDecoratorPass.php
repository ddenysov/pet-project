<?php
declare(strict_types=1);

namespace Denysov\Demo\Infrastructure\Container\Symfony\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Zinc\Core\Command\CommandHandlerInterface;

class CommandHandlerDecoratorPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        foreach ($container->getServiceIds() as $id) {
            if (str_starts_with($id, '.')) {
                continue;
            }

            if (!$container->hasDefinition($id)) {
                continue;
            }

            $definition = $container->getDefinition($id);

            if (
                $definition->isAbstract()
                || !$definition->getClass()
                || !is_a($definition->getClass(), CommandHandlerInterface::class, true)
            ) {
                continue;
            }

            $originalId = $id;
            $currentId = $originalId;

            $decorators = [
                \Zinc\Core\Command\Decorator\CommandHandler\EventStoreDecorator::class,
                \Zinc\Core\Command\Decorator\CommandHandler\RetryDecorator::class,
                \Zinc\Core\Command\Decorator\CommandHandler\EventBusDecorator::class,
            ];

            foreach ($decorators as $index => $decoratorClass) {
                $decoratorServiceId = $originalId . '.decorator_' . $index;

                $decoratorDef = new Definition($decoratorClass);
                $decoratorDef->setDecoratedService($currentId);
                $decoratorDef->setAutowired(true);
                $decoratorDef->setArgument('$inner', new Reference($decoratorServiceId . '.inner'));

                $container->setDefinition($decoratorServiceId, $decoratorDef);

                $currentId = $decoratorServiceId; // следующий будет декорировать этот
            }
        }
    }
}