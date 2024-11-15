<?php

namespace Ride\Domain\Event;

use Common\Domain\Event\Event;
use Common\Domain\ValueObject\DateTimeValue;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\ImageValue;
use Common\Domain\ValueObject\GeoLocationValue;
use Common\Domain\ValueObject\StringValue;
use Ride\Domain\ValueObject\OrganizerId;

class RideCreated extends Event implements RideEvent
{
    /**
     * @param OrganizerId $organizerId
     * @param StringValue $name
     * @param StringValue $description
     * @param DateTimeValue $dateTimeStart
     * @param DateTimeValue $dateTimeEnd
     * @param ImageValue $image
     * @param GeoLocationValue $locationStart
     * @param GeoLocationValue $locationFinish
     * @throws InvalidUuidException
     */
    public function __construct(
        private OrganizerId      $organizerId,
        private StringValue      $name,
        private StringValue      $description,
        private DateTimeValue    $dateTimeStart,
        private DateTimeValue    $dateTimeEnd,
        private ImageValue       $image,
        private GeoLocationValue $locationStart,
        private GeoLocationValue $locationFinish,
        private DateTimeValue    $createdAt,
        private DateTimeValue    $updatedAt,
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

    public function getLocationStart(): GeoLocationValue
    {
        return $this->locationStart;
    }

    public function getLocationFinish(): GeoLocationValue
    {
        return $this->locationFinish;
    }

    public function getImage(): ImageValue
    {
        return $this->image;
    }

    public function getCreatedAt(): DateTimeValue
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeValue
    {
        return $this->updatedAt;
    }
}