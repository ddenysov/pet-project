<?php

namespace Ride\Application\Handlers\Event;

use Ride\Application\Projector\Port\HealthCheckProjector;
use Ride\Domain\Event\HealthCheckOk;
use Ride\Domain\Event\RideCreated;
use Ride\Domain\Event\RideEvent;
use Ride\Infrastructure\Projector\Doctrine\RideProjector;

class RideCreatedEventHandler
{
    public function __construct(private RideProjector $projector)
    {
    }

    public function __invoke(RideCreated $event)
    {
        $this->projector->apply($event);
    }

}