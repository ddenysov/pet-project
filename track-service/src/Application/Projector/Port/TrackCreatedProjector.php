<?php

namespace Track\Application\Projector\Port;

use Track\Domain\Event\TrackCreated;

interface TrackCreatedProjector
{
    /**
     * @param TrackCreated $event
     * @return void
     */
    public function apply(TrackCreated $event): void;
}