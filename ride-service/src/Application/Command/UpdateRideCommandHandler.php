<?php

namespace Ride\Application\Command;

use Common\Application\Container\Port\ServiceContainer;
use Common\Application\Handlers\Command\CommandHandler;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Common\Domain\ValueObject\StringValue;
use Psr\Log\LoggerInterface;
use Ride\Domain\Exception\AccessDeniedException;
use Ride\Domain\Repository\Port\RideRepository;
use Ride\Domain\ValueObject\OrganizerId;
use Ride\Domain\ValueObject\RideId;


final class UpdateRideCommandHandler extends CommandHandler
{
    public function __construct(
        ServiceContainer $container,
        LoggerInterface $logger,
        private RideRepository $repository,
    ) {
        parent::__construct($container, $logger);
    }

    /**
     * @throws InvalidUuidException
     * @throws InvalidStringLengthException
     * @throws AccessDeniedException
     */
    protected function handle(UpdateRideCommand $command): void
    {
        $ride = $this->repository->find(new RideId($command->id));
        $ride->updateByOrganizer(
            name: new StringValue($command->name),
            organizerId: new OrganizerId($command->organizerId)
        );

        $this->repository->save($ride);
    }
}