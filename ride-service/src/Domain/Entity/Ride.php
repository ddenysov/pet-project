<?php

namespace Ride\Domain\Entity;

use Common\Domain\Entity\Aggregate;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Common\Domain\ValueObject\StringValue;
use Ride\Domain\Event\RideCreated;
use Ride\Domain\Event\RideUpdated;
use Ride\Domain\ValueObject\RideId;

class Ride extends Aggregate implements \Common\Domain\Entity\Port\Aggregate
{
    /**
     * @var StringValue
     */
    private StringValue $name;

    public function getId(): RideId
    {
        return RideId::fromUuid($this->id);
    }

    /**
     * @throws InvalidUuidException
     */
    public static function createRide(
        StringValue $name,
    ): Ride {
        $rideId = RideId::create();

        $ride = new static();
        $ride->recordThat(new RideCreated(aggregateId: $rideId, rideName: $name));

        return $ride;
    }

    /**
     * @throws InvalidStringLengthException
     * @throws InvalidUuidException
     */
    public function update(string $name): void
    {
        $this->recordThat(new RideUpdated(aggregateId: $this->getId(), rideName: new StringValue($name)));
    }

    /**
     * @param RideCreated $event
     * @return void
     */
    public function onRideCreated(RideCreated $event)
    {
        $this->id = $event->getAggregateId();
        $this->name = $event->getRideName();
    }

    /**
     * @param RideUpdated $event
     * @return void
     */
    public function onRideUpdated(RideUpdated $event)
    {
        $this->name = $event->getRideName();
    }
}