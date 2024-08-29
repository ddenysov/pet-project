<?php

namespace Ride\Application\Handlers\Event;

use Ride\Application\Projector\Port\HealthCheckProjector;
use Ride\Domain\Event\HealthCheckOk;
use Ride\Domain\Event\RideCreated;
use Ride\Domain\Event\RideEvent;
use Ride\Domain\Event\RideUpdated;
use Ride\Infrastructure\Projector\Doctrine\RideProjector;

class RideUpdatedEventHandler
{
    public function __construct(private RideProjector $projector)
    {
    }

    public function __invoke(RideUpdated $event)
    {
        $this->projector->apply($event);
    }

}