<?php

namespace Ride\Application\Event;

use Common\Application\Broadcaster\Port\Broadcaster;
use Common\Application\Outbox\Port\Outbox;
use Ride\Application\Projector\Port\RideCreatedProjector;
use Ride\Domain\Event\RideCreated;
use Ride\Domain\Repository\Port\RideRepository;

class RideCreatedEventHandler
{
    public function __construct(
        private RideCreatedProjector $projector,
        private Broadcaster $broadcaster,
        private Outbox $outbox,
    ) {
    }

    public function __invoke(RideCreated $event)
    {
        $this->outbox->save($event);
        $this->projector->apply($event);
        $this->broadcaster
            ->broadcastMessageTo($event->getOrganizerId(), $event);
    }
}