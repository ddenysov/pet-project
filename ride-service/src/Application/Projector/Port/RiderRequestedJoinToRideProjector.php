<?php

namespace Ride\Application\Projector\Port;

use Ride\Domain\Event\RiderJoinedToRide;
use Ride\Domain\Event\RiderRequestedJoinToRide;

interface RiderRequestedJoinToRideProjector
{
    /**
     * @param RiderRequestedJoinToRide $event
     * @return void
     */
    public function apply(RiderRequestedJoinToRide $event): void;
}