<?php

namespace Ride\Domain\Entity;

use Common\Domain\Entity\Aggregate;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\StringValue;
use Ride\Domain\Event\RideCreated;
use Ride\Domain\ValueObject\RideId;

class Ride extends Aggregate implements \Common\Domain\Entity\Port\Aggregate
{
    private StringValue $name;

    protected static array $subscribers = [
        RideCreated::class => [
            'onRideCreated',
        ],
    ];

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
     * @param RideCreated $event
     * @return void
     */
    public function onRideCreated(RideCreated $event)
    {
        $this->id = $event->getAggregateId();
        $this->name = $event->getRideName();
    }
}