<?php

namespace Ride\Domain\Event;

use Common\Domain\Event\Event;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\StringValue;
use Ride\Domain\ValueObject\RideId;

class RideCreated extends Event implements RideEvent
{
    /**
     * @param RideId $aggregateId
     * @param StringValue $name
     * @throws InvalidUuidException
     */
    public function __construct(
        RideId $aggregateId,
        private StringValue $name
    ) {
        parent::__construct();
        $this->aggregateId = $aggregateId;
    }

    /**
     * @return StringValue
     */
    public function getName(): StringValue
    {
        return $this->name;
    }
}