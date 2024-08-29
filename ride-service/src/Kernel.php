<?php

namespace Ride;

use Common\Application\EventHandler\Port\EventConsumer;
use Common\Application\EventHandler\Port\EventPublisher;
use Ride\Domain\Event\RideCreated;
use Ride\Domain\Event\RideUpdated;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Ride\Domain\Event\HealthCheckOk;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;


    public function boot(): void
    {
        parent::boot();
        $channelMap = [
            'ride' => [
                HealthCheckOk::getName(),
                RideCreated::getName(),
                RideUpdated::getName(),
            ]
        ];

        $this->container->get(EventPublisher::class)->configureChannelMap($channelMap);
        $this->container->get(EventConsumer::class)->configureChannelMap($channelMap);
    }
}
