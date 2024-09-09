<?php

namespace Ride\Application\Projector\Port;

use Ride\Domain\Event\RiderJoinedToRide;

interface RiderJoinedProjector
{
    /**
     * @param RiderJoinedToRide $event
     * @return void
     */
    public function apply(RiderJoinedToRide $event): void;
}