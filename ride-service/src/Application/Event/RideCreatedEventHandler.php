<?php

namespace Ride\Application\Event;

use Common\Application\Broadcaster\Port\Broadcaster;
use Ride\Application\Projector\Port\RideCreatedProjector;
use Ride\Domain\Event\RideCreated;

class RideCreatedEventHandler
{
    public function __construct(private RideCreatedProjector $projector, private Broadcaster $broadcaster)
    {
    }

    public function __invoke(RideCreated $event)
    {
        $this->projector->apply($event);
        $this->broadcaster->broadcastMessageTo($event->getOrganizerId(), $event);
    }
}