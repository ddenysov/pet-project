<?php

namespace Template\Application\Handlers\Event;

use Iam\Application\Projector\Port\UserProjector;
use Iam\Domain\Event\UserRegistered;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Template\Application\Projector\Port\HealthCheckProjector;
use Template\Domain\Event\HealthCheckOk;

class HealthCheckEventHandler
{
    public function __construct(private HealthCheckProjector $projector)
    {
    }

    public function __invoke(HealthCheckOk $event)
    {
        dump('HANDLED');
        $this->projector->apply($event);
    }

}