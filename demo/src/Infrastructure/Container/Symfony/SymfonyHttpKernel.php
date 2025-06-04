<?php
declare(strict_types=1);

namespace Denysov\Demo\Infrastructure\Container\Symfony;

use Denysov\Demo\Infrastructure\Container\Symfony\Compiler\CommandHandlerDecoratorPass;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class SymfonyHttpKernel extends BaseKernel
{
    use MicroKernelTrait;


    public function registerBundles(): iterable
    {
        yield new FrameworkBundle();
        yield new MonologBundle();
    }

    protected function configureContainer(ContainerConfigurator $c, LoaderInterface $loader): void
    {
        // тянем DI-конфиги из YAML
        $c->import(dirname(__DIR__, 2) .'/config/{services}.yaml');
        $loader->load(dirname(__DIR__, 2) .'/config/packages/monolog.yaml');
        $loader->load(dirname(__DIR__, 2) .'/config/packages/messenger.yaml');
    }

    protected function configureRoutes(RoutingConfigurator $r): void
    {
        // импорт маршрутов из YAML
        $r->import(dirname(__DIR__, 2).'/config/routes.yaml');
    }

    public function getLogDir(): string
    {
        return dirname(__DIR__, 2).'/var/log';
    }

    #[\Override] protected function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new CommandHandlerDecoratorPass());
    }
}