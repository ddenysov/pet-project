<?php

namespace Ride\Application\Handlers\Command;

use Common\Application\Container\Port\ServiceContainer;
use Common\Application\Handlers\Command\CommandHandler;
use Common\Domain\ValueObject\StringValue;
use Psr\Log\LoggerInterface;
use Ride\Domain\Entity\Healthcheck;
use Ride\Domain\Entity\Ride;
use Ride\Domain\Repository\Port\HealthCheckRepository;
use Ride\Domain\Repository\Port\RideRepository;


final class CreateRideCommandHandler extends CommandHandler
{
    public function __construct(
        ServiceContainer $container,
        LoggerInterface $logger,
        private RideRepository $repository,
    ) {
        parent::__construct($container, $logger);
    }

    protected function handle(CreateRideCommand $command): void
    {
        $ride = Ride::create(new StringValue($command->name));

        $this->repository->save($ride);
    }
}