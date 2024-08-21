<?php

namespace Template;

use Common\Application\EventHandler\Port\EventConsumer;
use Common\Application\EventHandler\Port\EventPublisher;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Template\Domain\Event\HealthCheckOk;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;


    public function boot(): void
    {
        parent::boot();
        $channelMap = [
            'template' => [
                HealthCheckOk::getName(),
            ]
        ];

        $this->container->get(EventPublisher::class)->configureChannelMap($channelMap);
        $this->container->get(EventConsumer::class)->configureChannelMap($channelMap);
    }
}
