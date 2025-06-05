<?php
declare(strict_types=1);

namespace Zinc\Core\Container\Symfony;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Zinc\Core\Container\Symfony\Compiler\CommandHandlerDecoratorPass;
use Zinc\Core\Kernel\KernelConfig;

class SymfonyHttpKernel extends BaseKernel
{
    use MicroKernelTrait;


    /**
     * @param KernelConfig $config
     */
    public function __construct(private KernelConfig $config)
    {
        parent::__construct('local', true);
    }

    public function registerBundles(): iterable
    {
        yield new FrameworkBundle();
        yield new MonologBundle();
        yield new SymfonyCoreBundle();
    }

    protected function configureContainer(ContainerConfigurator $c, LoaderInterface $loader): void
    {
        $c->import($this->config->getBaseDir() .'/config/{services}.yaml');
    }

    protected function configureRoutes(RoutingConfigurator $r): void
    {
        $r->import($this->config->getBaseDir().'/config/routes.yaml');
    }

    public function getLogDir(): string
    {
        return $this->config->getBaseDir().'/var/log';
    }

    public function getCacheDir(): string
    {
        return $this->config->getBaseDir().'/var/cache';
    }

    #[\Override] protected function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new CommandHandlerDecoratorPass());
    }
}