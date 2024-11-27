<?php

namespace Ride\Application\Handlers\Event;

use Common\Application\Broadcaster\Port\Broadcaster;
use Common\Application\Bus\Port\CommandBus;
use Ride\Application\Projector\Port\RiderRequestAcceptedJoinToRideProjector;
use Ride\Domain\Event\RiderRequestAcceptedJoinToRide;
use Ride\Infrastructure\Projector\Doctrine\RideJoinRequestedProjector;

final readonly class RiderJoinAcceptedEventHandler
{
    /**
     * @param RideJoinRequestedProjector $projector
     * @param Broadcaster $broadcaster
     * @param CommandBus $commandBus
     */
    public function __construct(
        private RiderRequestAcceptedJoinToRideProjector $projector,
        private Broadcaster $broadcaster,
    ) {
    }

    /**
     * @param RiderRequestAcceptedJoinToRide $event
     * @return void
     */
    public function __invoke(RiderRequestAcceptedJoinToRide $event): void
    {
        $this->projector->apply($event);
        $this->broadcaster->broadcastMessageTo($event->getRiderId(), $event);
    }
}