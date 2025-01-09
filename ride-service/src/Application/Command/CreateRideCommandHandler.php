<?php

namespace Ride\Application\Command;

use Common\Application\Bus\Port\EventBus;
use Common\Application\Handlers\Command\CommandHandler;
use Common\Domain\ValueObject\DateTimeValue;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Common\Domain\ValueObject\GeoLocationValue;
use Common\Domain\ValueObject\ImageValue;
use Psr\Log\LoggerInterface;
use Ride\Domain\Entity\Ride;
use Ride\Domain\Repository\Port\RideRepository;
use Ride\Domain\ValueObject\OrganizerId;
use Ride\Domain\ValueObject\RideDescription;
use Ride\Domain\ValueObject\RideName;
use Ride\Domain\ValueObject\RideRules;


final class CreateRideCommandHandler extends CommandHandler
{
    /**
     * @param EventBus $eventBus
     * @param RideRepository $repository
     */
    public function __construct(
        private readonly EventBus       $eventBus,
        private readonly RideRepository $repository,
    )
    {
    }

    /**
     * @throws InvalidStringLengthException
     * @throws InvalidUuidException
     * @throws \Exception
     */
    protected function handle(CreateRideCommand $command): void
    {
        $ride = Ride::create(
            organizerId: new OrganizerId($command->organizerId),
            name: new RideName($command->name),
            description: new RideDescription($command->description),
            rules: new RideRules($command->description),
            dateTimeStart: new DateTimeValue($command->dateTimeStart),
            dateTimeEnd: new DateTimeValue($command->dateTimeEnd),
            image: ImageValue::fromUrl($command->image),
            locationStart: GeoLocationValue::fromArray($command->locationStart),
            locationFinish: GeoLocationValue::fromArray($command->locationFinish),
        );

        $events = $this->repository->save($ride);
    }
}