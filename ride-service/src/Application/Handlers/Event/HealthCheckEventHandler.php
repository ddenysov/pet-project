<?php

namespace Ride\Application\Handlers\Event;

use Ride\Application\Projector\Port\HealthCheckProjector;
use Ride\Domain\Event\HealthCheckOk;

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