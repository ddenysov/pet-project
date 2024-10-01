<?php

namespace Ride\Domain\Event;

use Common\Domain\Event\Event;
use Common\Domain\ValueObject\DateTimeValue;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\ImageValue;
use Common\Domain\ValueObject\LocationValue;
use Common\Domain\ValueObject\StringValue;
use Ride\Domain\ValueObject\OrganizerId;
use Ride\Domain\ValueObject\RideId;

class RideCreated extends Event implements RideEvent
{
    /**
     * @param OrganizerId $organizerId
     * @param StringValue $name
     * @param StringValue $description
     * @param DateTimeValue $dateTimeStart
     * @param DateTimeValue $dateTimeEnd
     * @param ImageValue $image
     * @param LocationValue $locationStart
     * @param LocationValue $locationFinish
     * @throws InvalidUuidException
     */
    public function __construct(
        private OrganizerId   $organizerId,
        private StringValue   $name,
        private StringValue   $description,
        private DateTimeValue $dateTimeStart,
        private DateTimeValue $dateTimeEnd,
        private ImageValue    $image,
        private LocationValue $locationStart,
        private LocationValue $locationFinish
    )
    {
        parent::__construct();
    }

    /**
     * @return StringValue
     */
    public function getName(): StringValue
    {
        return $this->name;
    }

    public function getOrganizerId(): OrganizerId
    {
        return $this->organizerId;
    }

    public function getDescription(): StringValue
    {
        return $this->description;
    }

    public function getDateTimeStart(): DateTimeValue
    {
        return $this->dateTimeStart;
    }

    public function getDateTimeEnd(): DateTimeValue
    {
        return $this->dateTimeEnd;
    }

    public function getLocationStart(): LocationValue
    {
        return $this->locationStart;
    }

    public function getLocationFinish(): LocationValue
    {
        return $this->locationFinish;
    }

    public function getImage(): ImageValue
    {
        return $this->image;
    }
}