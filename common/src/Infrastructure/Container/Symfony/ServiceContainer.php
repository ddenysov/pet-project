<?php

namespace Common\Infrastructure\Container\Symfony;

use Common\Application\Container\Port\ServiceContainer as ServiceContainerPort;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ServiceContainer implements ServiceContainerPort
{
    public function __construct(private ContainerInterface $container)
    {

    }
    public function get(string $id)
    {
        return $this->container->get($id);
    }

    public function has(string $id): bool
    {
        return $this->container->has($id);
    }
}