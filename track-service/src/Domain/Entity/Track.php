<?php

namespace Track\Domain\Entity;

use Common\Domain\Entity\Aggregate;
use Common\Domain\ValueObject\Uuid;
use Track\Domain\Event\HealthCheckOk;
use Track\Domain\ValueObject\CreatorId;
use Track\Domain\ValueObject\TrackName;
use Track\Domain\ValueObject\TrackPath;

class Track extends Aggregate implements \Common\Domain\Entity\Port\Aggregate
{
    public static function create(
        CreatorId $creatorId,
        TrackName $trackName,
        TrackPath $trackPath,
    ): Track {
        $instance = new static();
        $instance->setId(Uuid::create());
        $event = new HealthCheckOk();
        $event->setAggregateId($instance->getId());
        $instance->recordThat($event);

        return $instance;
    }

    public function onHealthCheckOk()
    {
        // do nothing
    }
}