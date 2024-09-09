<?php

namespace Ride\Application\Handlers\Event;

use Ride\Application\Projector\Port\RiderJoinedProjector;
use Ride\Domain\Event\RiderJoinedToRide;

final readonly class RiderJoinedEventHandler
{
    /**
     * @param RiderJoinedProjector $projector
     */
    public function __construct(private RiderJoinedProjector $projector)
    {
    }

    /**
     * @param RiderJoinedToRide $event
     * @return void
     */
    public function __invoke(RiderJoinedToRide $event): void
    {
        $this->projector->apply($event);
    }
}