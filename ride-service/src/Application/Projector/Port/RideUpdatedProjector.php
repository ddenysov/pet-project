<?php

namespace Ride\Application\Projector\Port;

use Ride\Domain\Event\RideUpdated;

interface RideUpdatedProjector
{
    /**
     * @param RideUpdated $event
     * @return void
     */
    public function apply(RideUpdated $event): void;
}