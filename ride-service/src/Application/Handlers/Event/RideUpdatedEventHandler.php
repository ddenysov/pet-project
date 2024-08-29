<?php

namespace Ride\Application\Handlers\Event;

use Ride\Application\Projector\Port\RideUpdatedProjector;
use Ride\Domain\Event\RideUpdated;

final readonly class RideUpdatedEventHandler
{
    /**
     * @param RideUpdatedProjector $projector
     */
    public function __construct(private RideUpdatedProjector $projector)
    {
    }

    /**
     * @param RideUpdated $event
     * @return void
     */
    public function __invoke(RideUpdated $event): void
    {
        $this->projector->apply($event);
    }
}