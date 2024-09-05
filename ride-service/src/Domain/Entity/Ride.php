<?php

namespace Ride\Domain\Entity;

use Common\Domain\Entity\Aggregate;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Common\Domain\ValueObject\StringValue;
use Ride\Domain\Event\RideCreated;
use Ride\Domain\Event\RideUpdated;
use Ride\Domain\ValueObject\OrganizerId;
use Ride\Domain\ValueObject\RideId;

class Ride extends Aggregate implements \Common\Domain\Entity\Port\Aggregate
{
    /**
     * @var StringValue
     */
    private StringValue $name;

    /**
     * @var OrganizerId
     */
    private OrganizerId $organizerId;

    public function getId(): RideId
    {
        return RideId::fromUuid($this->id);
    }

    /**
     * @throws InvalidUuidException
     */
    public static function create(
        OrganizerId $organizerId,
        StringValue $name,
    ): Ride
    {
        $rideId = RideId::create();

        $ride = new static();
        $ride->setId($rideId);
        $ride->recordThat(new RideCreated(
            name: $name,
            organizerId: $organizerId,
        ));

        return $ride;
    }

    /**
     * @throws InvalidStringLengthException
     * @throws InvalidUuidException
     */
    public function update(string $name): void
    {
        $this->recordThat(new RideUpdated(aggregateId: $this->getId(), name: new StringValue($name)));
    }

    /**
     * @param RideCreated $event
     * @return void
     */
    public function onRideCreated(RideCreated $event)
    {
        $this->id          = $event->getAggregateId();
        $this->name        = $event->getName();
        $this->organizerId = $event->getOrganizerId();
    }

    /**
     * @param RideUpdated $event
     * @return void
     */
    public function onRideUpdated(RideUpdated $event)
    {
        $this->name = $event->getName();
    }

    public function getName(): StringValue
    {
        return $this->name;
    }

    public function setName(StringValue $name): void
    {
        $this->name = $name;
    }

    public function getOrganizerId(): OrganizerId
    {
        return $this->organizerId;
    }

    public function setOrganizerId(OrganizerId $organizerId): void
    {
        $this->organizerId = $organizerId;
    }
}