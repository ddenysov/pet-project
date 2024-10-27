<?php

namespace Ride\Application\Handlers\Command;

use Common\Application\Container\Port\ServiceContainer;
use Common\Application\Handlers\Command\CommandHandler;
use Common\Domain\ValueObject\DateTimeValue;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Common\Domain\ValueObject\ImageValue;
use Common\Domain\ValueObject\GeoLocationValue;
use Common\Domain\ValueObject\StringValue;
use Psr\Log\LoggerInterface;
use Ride\Domain\Entity\Ride;
use Ride\Domain\Repository\Port\RideRepository;
use Ride\Domain\ValueObject\OrganizerId;


final class CreateRideCommandHandler extends CommandHandler
{
    public function __construct(
        ServiceContainer       $container,
        LoggerInterface        $logger,
        private RideRepository $repository,
    )
    {
        parent::__construct($container, $logger);
    }

    /**
     * @throws InvalidStringLengthException
     * @throws InvalidUuidException
     */
    protected function handle(CreateRideCommand $command): void
    {
        $ride = Ride::create(
            organizerId: new OrganizerId($command->organizerId),
            name: new StringValue($command->name),
            description: new StringValue($command->description),
            dateTimeStart: new DateTimeValue($command->dateTimeStart),
            dateTimeEnd: new DateTimeValue($command->dateTimeEnd),
            image: ImageValue::fromUrl($command->image),
            locationStart: GeoLocationValue::fromArray($command->locationStart),
            locationFinish: GeoLocationValue::fromArray($command->locationFinish),
        );

        $this->repository->save($ride);
    }
}