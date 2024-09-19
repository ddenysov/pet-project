<?php

namespace Ride\Application\Handlers\Command;

use Common\Application\Container\Port\ServiceContainer;
use Common\Application\Handlers\Command\CommandHandler;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Common\Domain\ValueObject\StringValue;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Ride\Domain\Entity\Healthcheck;
use Ride\Domain\Entity\Ride;
use Ride\Domain\Event\RiderRequestedJoinToRide;
use Ride\Domain\Exception\AccessDeniedException;
use Ride\Domain\Repository\Port\HealthCheckRepository;
use Ride\Domain\Repository\Port\RideRepository;
use Ride\Domain\ValueObject\OrganizerId;
use Ride\Domain\ValueObject\RideId;
use Ride\Domain\ValueObject\RiderId;


final class JoinRideCommandHandler extends CommandHandler
{
    public function __construct(
        ServiceContainer $container,
        LoggerInterface $logger,
        private RideRepository $repository,
    ) {
        parent::__construct($container, $logger);
    }

    /**
     * @param JoinRideCommand $command
     * @throws AccessDeniedException
     * @throws InvalidUuidException
     */
    protected function handle(JoinRideCommand $command): void
    {
        $ride = $this->repository->find(new RideId($command->rideId));
        $ride->requestToJoin(
            riderId: new RiderId($command->riderId),
        );

        $this->repository->save($ride);
    }
}