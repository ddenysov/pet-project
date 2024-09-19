<?php

namespace Common\Infrastructure\Container\Symfony;

use Common\Infrastructure\Container\Symfony\CompilerPass\EventRouterCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class CommonBundle extends AbstractBundle
{
    /**
     * @param array $config
     * @param ContainerConfigurator $container
     * @param ContainerBuilder $builder
     * @return void
     */
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        // load an XML, PHP or YAML file
        $container->import('../../../../config/services.yml');
    }

    #[\Override] public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new EventRouterCompilerPass());
    }


}