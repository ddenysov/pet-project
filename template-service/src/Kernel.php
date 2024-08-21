<?php

namespace Template;

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

        $service = $this->container->get(EventPublisher::class);
        $service->configureChannelMap([
            'template' => [
                HealthCheckOk::getName(),
            ]
        ]);
    }


}
