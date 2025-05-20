<?php
declare(strict_types=1);

namespace Denysov\Demo\Container;

use Denysov\Demo\Delivery\Http\IndexController;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ContainerControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class SymfonyContainerFactory
{
    public static function create(): ContainerInterface
    {
        $container = new ContainerBuilder();
        $container
            ->register('event_dispatcher', EventDispatcher::class);

        $container->register('request_stack', RequestStack::class);

        $container->register('controller_resolver', ContainerControllerResolver::class)
            ->setArguments([
                new Reference('service_container'),   // PSR\Container\ContainerInterface
                // new Reference('logger')            // опционально
            ]);

        $container->register('argument_resolver', ArgumentResolver::class);

        $container->register('kernel', HttpKernel::class)
            ->setArguments([
                new Reference('event_dispatcher'),
                new Reference('controller_resolver'),
                new Reference('request_stack'),
                new Reference('argument_resolver'),
            ])
            ->setPublic(true);

        $routes = new RouteCollection();

        $routes->add('entry', new Route(
            path: '/',
            defaults: ['_controller' => [IndexController::class, 'index']]
        ));

        /** routes */
        $container->register('routes', RouteCollection::class)
            ->setFactory($routes->all());

        /** context + url_matcher */
        $container->register('context', RequestContext::class);

        $container->register('url_matcher', UrlMatcher::class)
            ->setArguments([
                new Reference('routes'),
                new Reference('context'),
            ]);

        /** router_listener */
        $container->register('router_listener', RouterListener::class)
            ->setArguments([
                new Reference('url_matcher'),
                new Reference('context'),
            ])
            ->addTag('kernel.event_subscriber');

        $container->compile();

        return $container;
    }
}