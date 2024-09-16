<?php

namespace Ride\Application\Handlers\Event;

use Ride\Application\Projector\Port\RiderJoinedProjector;
use Ride\Domain\Event\RiderJoinedToRide;
use Ride\Domain\Event\RiderRequestedJoinToRide;
use Ride\Infrastructure\Projector\Doctrine\RideJoinRequestedProjector;

final readonly class RiderJoinRequestedEventHandler
{
    /**
     * @param RideJoinRequestedProjector $projector
     */
    public function __construct(private RideJoinRequestedProjector $projector)
    {
    }

    /**
     * @param RiderRequestedJoinToRide $event
     * @return void
     */
    public function __invoke(RiderRequestedJoinToRide $event): void
    {
        $this->projector->apply($event);
    }
}