<?php

namespace Track\Application\Event;

use Common\Application\Broadcaster\Port\Broadcaster;
use Track\Application\Projector\Port\TrackCreatedProjector;
use Track\Domain\Event\TrackCreated;

class TrackCreatedEventHandler
{
    public function __construct(private TrackCreatedProjector $projector, private Broadcaster $broadcaster)
    {
    }

    public function __invoke(TrackCreated $event)
    {
        $this->projector->apply($event);
    }
}