<?php

namespace Ride\Application\Handlers\Command;

use Common\Application\Container\Port\ServiceContainer;
use Common\Application\Handlers\Command\CommandHandler;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\StringValue;
use Psr\Log\LoggerInterface;
use Ride\Domain\Entity\Healthcheck;
use Ride\Domain\Entity\Ride;
use Ride\Domain\Repository\Port\HealthCheckRepository;
use Ride\Domain\Repository\Port\RideRepository;
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
     */
    protected function handle(UpdateRideCommand $command): void
    {
        $ride = $this->repository->find(new RideId($command->id));

        dd($ride);

        $this->repository->save($ride);
    }
}