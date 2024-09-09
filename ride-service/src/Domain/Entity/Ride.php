<?php

namespace Ride\Domain\Entity;

use Common\Domain\Entity\Aggregate;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Common\Domain\ValueObject\StringValue;
use Ride\Domain\Event\RideCreated;
use Ride\Domain\Event\RiderJoinedToRide;
use Ride\Domain\Event\RideUpdated;
use Ride\Domain\Exception\AccessDeniedException;
use Ride\Domain\ValueObject\OrganizerId;
use Ride\Domain\ValueObject\RideId;
use Ride\Domain\ValueObject\RiderId;

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

    /**
     * @var array
     */
    protected array $riders = [];

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
            organizerId: $organizerId,
            name: $name,
        ));

        return $ride;
    }

    /**
     * @throws InvalidUuidException
     * @throws AccessDeniedException
     */
    public function updateByOrganizer(StringValue $name, OrganizerId $organizerId): void
    {
        if ($this->organizerId->notEquals($organizerId)) {
            throw new AccessDeniedException('Organizer can edit only its own rides');
        }

        $this->recordThat(new RideUpdated(
            aggregateId: $this->getId(),
            name: $name
        ));
    }

    /**
     * @param RiderId $riderId
     * @return void
     * @throws InvalidUuidException
     * @throws AccessDeniedException
     */
    public function join(RiderId $riderId): void
    {
        /**
         * @var RiderId $rider
         */
        foreach ($this->riders as $rider) {
            if ($rider->equals($riderId)) {
                throw new AccessDeniedException('Rider already joined the ride');
            }
        }

        $this->recordThat(new RiderJoinedToRide(
            aggregateId: $this->getId(),
            riderId: $riderId,
        ));
    }

    /**
     * @param RiderJoinedToRide $event
     * @return void
     * @throws AccessDeniedException
     */
    public function onRiderJoinedToRide(RiderJoinedToRide $event)
    {
        $this->riders[] = $event->getRiderId();
    }

    /**
     * @param RideCreated $event
     * @return void
     */
    public function onRideCreated(RideCreated $event): void
    {
        $this->id          = $event->getAggregateId();
        $this->name        = $event->getName();
        $this->organizerId = $event->getOrganizerId();
    }

    /**
     * @param RideUpdated $event
     * @return void
     */
    public function onRideUpdated(RideUpdated $event): void
    {
        $this->name = $event->getRideName();
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