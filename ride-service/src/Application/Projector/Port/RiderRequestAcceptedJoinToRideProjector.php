<?php

namespace Ride\Application\Projector\Port;

use Ride\Domain\Event\RiderRequestAcceptedJoinToRide;

interface RiderRequestAcceptedJoinToRideProjector
{
    /**
     * @param RiderRequestAcceptedJoinToRide $event
     * @return void
     */
    public function apply(RiderRequestAcceptedJoinToRide $event): void;
}