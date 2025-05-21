<?php
declare(strict_types=1);

namespace Denysov\Demo\Container;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class SymfonyHttpKernel extends BaseKernel
{
    use MicroKernelTrait;


    public function registerBundles(): iterable
    {
        yield new FrameworkBundle();
    }

    protected function configureContainer(ContainerConfigurator $c): void
    {
        // тянем DI-конфиги из YAML
        $c->import(dirname(__DIR__, 2) .'/config/{services}.yaml');
    }

    protected function configureRoutes(RoutingConfigurator $r): void
    {
        // импорт маршрутов из YAML
        $r->import(dirname(__DIR__, 2).'/config/routes.yaml');
    }
}