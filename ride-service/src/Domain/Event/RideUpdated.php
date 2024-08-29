<?php

namespace Ride\Domain\Event;

use Common\Domain\Event\Event;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\StringValue;
use Ride\Domain\ValueObject\RideId;

class RideUpdated extends Event implements RideEvent
{
    /**
     * @param RideId $aggregateId
     * @param StringValue $rideName
     * @throws InvalidUuidException
     */
    public function __construct(
        RideId $aggregateId,
        private StringValue $rideName
    ) {
        parent::__construct();
        $this->aggregateId = $aggregateId;
    }


    public function getRideName(): StringValue
    {
        return $this->rideName;
    }
}