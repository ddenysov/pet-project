<?php
declare(strict_types=1);

namespace Denysov\Demo\Container;

use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ContainerControllerResolver;

class ContainerFactory
{
    public static function create(): ContainerInterface
    {
        $container = new ContainerBuilder();

        $container
            ->register('event_dispatcher', EventDispatcher::class);

        $container
            ->register('controller_resolver', ContainerControllerResolver::class)
            ->setArguments([new RequestStack(), $container]);

        $container->compile();

        return $container;
    }
}