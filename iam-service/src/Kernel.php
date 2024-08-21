<?php

namespace Iam;

use Common\Application\EventHandler\Port\EventConsumer;
use Common\Application\EventHandler\Port\EventPublisher;
use Iam\Domain\Event\UserPasswordResetRequested;
use Iam\Domain\Event\UserRegistered;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function boot(): void
    {
        parent::boot();
        $channelMap = [
            'iam' => [
                UserPasswordResetRequested::getName(),
                UserRegistered::getName(),
            ]
        ];

        $this->container->get(EventPublisher::class)->configureChannelMap($channelMap);
        $this->container->get(EventConsumer::class)->configureChannelMap($channelMap);
    }
}
