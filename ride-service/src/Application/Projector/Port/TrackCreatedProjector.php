<?php

namespace Ride\Application\Projector\Port;

use Ride\Domain\Event\TrackCreated;

interface TrackCreatedProjector
{
    /**
     * @param TrackCreated $event
     * @return void
     */
    public function apply(TrackCreated $event): void;
}