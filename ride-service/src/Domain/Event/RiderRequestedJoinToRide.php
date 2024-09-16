<?php

namespace Ride\Domain\Event;

use Common\Domain\Event\Event;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Ride\Domain\ValueObject\OrganizerId;
use Ride\Domain\ValueObject\RideId;
use Ride\Domain\ValueObject\RiderId;

class RiderRequestedJoinToRide extends Event implements RideEvent
{
    /**
     * @param RideId $aggregateId
     * @param RiderId $riderId
     * @throws InvalidUuidException
     */
    public function __construct(
        RideId $aggregateId,
        private readonly RiderId $riderId
    ) {
        parent::__construct();
        $this->aggregateId = $aggregateId;
    }

    /**
     * @return RiderId
     */
    public function getRiderId(): RiderId
    {
        return $this->riderId;
    }
}