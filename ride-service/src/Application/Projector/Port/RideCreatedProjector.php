<?php

namespace Ride\Application\Projector\Port;

use Ride\Domain\Event\RideCreated;

interface RideCreatedProjector
{
    /**
     * @param RideCreated $event
     * @return void
     */
    public function apply(RideCreated $event): void;
}