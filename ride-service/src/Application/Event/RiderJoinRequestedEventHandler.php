<?php

namespace Ride\Application\Event;

use Common\Application\Broadcaster\Port\Broadcaster;
use Common\Application\Bus\Port\CommandBus;
use Ride\Application\Command\AcceptJoinRideCommand;
use Ride\Domain\Event\RiderRequestedJoinToRide;
use Ride\Infrastructure\Projector\Doctrine\RideJoinRequestedProjector;

final readonly class RiderJoinRequestedEventHandler
{
    /**
     * @param RideJoinRequestedProjector $projector
     * @param Broadcaster $broadcaster
     * @param CommandBus $commandBus
     */
    public function __construct(
        private RideJoinRequestedProjector $projector,
        private Broadcaster $broadcaster,
        private CommandBus $commandBus,
    ) {
    }

    /**
     * @param RiderRequestedJoinToRide $event
     * @return void
     */
    public function __invoke(RiderRequestedJoinToRide $event): void
    {
        $this->projector->apply($event);
        $this->commandBus->execute(new AcceptJoinRideCommand(
            rideId: $event->getAggregateId()->toString(),
            riderId: $event->getRiderId()->toString(),
        ));
    }
}