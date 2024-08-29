<?php

namespace Ride\Application\Handlers\Event;

use Ride\Application\Projector\Port\RideCreatedProjector;
use Ride\Domain\Event\RideCreated;

class RideCreatedEventHandler
{
    public function __construct(private RideCreatedProjector $projector)
    {
    }

    public function __invoke(RideCreated $event)
    {
        $this->projector->apply($event);
    }
}