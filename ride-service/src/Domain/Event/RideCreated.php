<?php

namespace Ride\Domain\Event;

use Common\Domain\Event\Event;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\StringValue;
use Ride\Domain\ValueObject\OrganizerId;
use Ride\Domain\ValueObject\RideId;

class RideCreated extends Event implements RideEvent
{
    /**
     * @param OrganizerId $organizerId
     * @param StringValue $name
     * @throws InvalidUuidException
     */
    public function __construct(
        private OrganizerId $organizerId,
        private StringValue $name
    ) {
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
}