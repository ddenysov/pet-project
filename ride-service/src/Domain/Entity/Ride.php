<?php

namespace Ride\Domain\Entity;

use Common\Domain\Entity\Aggregate;
use Common\Domain\ValueObject\DateTimeValue;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Common\Domain\ValueObject\ImageValue;
use Common\Domain\ValueObject\GeoLocationValue;
use Common\Domain\ValueObject\StringValue;
use Ride\Domain\Event\RideCreated;
use Ride\Domain\Event\RiderJoinedToRide;
use Ride\Domain\Event\RiderRequestAcceptedJoinToRide;
use Ride\Domain\Event\RiderRequestedJoinToRide;
use Ride\Domain\Event\RideUpdated;
use Ride\Domain\Exception\AccessDeniedException;
use Ride\Domain\Exception\RiderAlreadyJoinedTheRideException;
use Ride\Domain\Exception\RiderAlreadyRequestedJoinTheRideException;
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
     * @var StringValue
     */
    private StringValue $description;

    /**
     * @var DateTimeValue
     */
    private DateTimeValue $dateTimeStart;

    /**
     * @var DateTimeValue
     */
    private DateTimeValue $dateTimeEnd;

    /**
     * @var ImageValue
     */
    private ImageValue $image;

    /**
     * @var GeoLocationValue
     */
    private GeoLocationValue $locationStart;

    /**
     * @var GeoLocationValue
     */
    private GeoLocationValue $locationFinish;

    /**
     * @var array
     */
    protected array $joinedRiders = [];

    /**
     * @var array
     */
    protected array $requestedToJoinRiders = [];

    /**
     * @return RideId
     * @throws InvalidUuidException
     */
    public function getId(): RideId
    {
        return RideId::fromUuid($this->id);
    }

    /**
     * @throws InvalidUuidException
     */
    public static function create(
        OrganizerId      $organizerId,
        StringValue      $name,
        StringValue      $description,
        DateTimeValue    $dateTimeStart,
        DateTimeValue    $dateTimeEnd,
        ImageValue       $image,
        GeoLocationValue $locationStart,
        GeoLocationValue $locationFinish
    ): Ride
    {
        $rideId = RideId::create();

        $ride = new static();
        $ride->setId($rideId);
        $ride->recordThat(new RideCreated(
            organizerId: $organizerId,
            name: $name,
            description: $description,
            dateTimeStart: $dateTimeStart,
            dateTimeEnd: $dateTimeEnd,
            image: $image,
            locationStart: $locationStart,
            locationFinish: $locationFinish,
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
     * @throws RiderAlreadyJoinedTheRideException
     */
    public function acceptRiderRequest(RiderId $riderId)
    {
        /**
         * @var RiderId $rider
         */
        foreach ($this->joinedRiders as $rider) {
            if ($rider->equals($riderId)) {
                throw new RiderAlreadyJoinedTheRideException('Rider already joined the ride');
            }
        }

        $this->recordThat(new RiderRequestAcceptedJoinToRide(
            aggregateId: $this->getId(),
            riderId: $riderId,
        ));
    }

    /**
     * @param RiderId $riderId
     * @return void
     * @throws InvalidUuidException
     * @throws AccessDeniedException
     */
    public function requestToJoin(RiderId $riderId): void
    {
        /**
         * @var RiderId $rider
         */
        foreach ($this->joinedRiders as $rider) {
            if ($rider->equals($riderId)) {
                throw new RiderAlreadyJoinedTheRideException('Rider already joined the ride');
            }
        }

        foreach ($this->requestedToJoinRiders as $rider) {
            if ($rider->equals($riderId)) {
                throw new RiderAlreadyRequestedJoinTheRideException('Rider already requested to join ride');
            }
        }

        $this->recordThat(new RiderRequestedJoinToRide(
            aggregateId: $this->getId(),
            riderId: $riderId,
        ));
    }

    /**
     * @param RiderRequestedJoinToRide $event
     * @return void
     */
    public function onRiderRequestedJoinToRide(RiderRequestedJoinToRide $event): void
    {
        $this->requestedToJoinRiders[] = $event->getRiderId();
    }

    /**
     * @param RiderRequestAcceptedJoinToRide $event
     * @return void
     */
    public function onRiderRequestAcceptedJoinToRide(RiderRequestAcceptedJoinToRide $event)
    {
        $this->joinedRiders[] = $event->getRiderId();
    }

    /**
     * @param RideCreated $event
     * @return void
     */
    public function onRideCreated(RideCreated $event): void
    {
        $this->id            = $event->getAggregateId();
        $this->name          = $event->getName();
        $this->organizerId   = $event->getOrganizerId();
        $this->description   = $event->getDescription();
        $this->image         = $event->getImage();
        $this->dateTimeStart = $event->getDateTimeStart();
        $this->dateTimeEnd   = $event->getDateTimeEnd();
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

    public function getOrganizerId(): OrganizerId
    {
        return $this->organizerId;
    }
}