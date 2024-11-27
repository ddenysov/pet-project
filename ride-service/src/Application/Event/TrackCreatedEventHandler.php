<?php

namespace Ride\Application\Event;

use Common\Application\Broadcaster\Port\Broadcaster;
use Ride\Application\Projector\Port\TrackCreatedProjector;
use Ride\Domain\Event\TrackCreated;

class TrackCreatedEventHandler
{
    public function __construct(private TrackCreatedProjector $projector, private Broadcaster $broadcaster)
    {
    }

    public function __invoke(TrackCreated $event): void
    {
        $this->projector->apply($event);
    }
}