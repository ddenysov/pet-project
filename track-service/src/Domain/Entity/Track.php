<?php

namespace Track\Domain\Entity;

use Common\Domain\Entity\Aggregate;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Uuid;
use Track\Domain\Event\HealthCheckOk;
use Track\Domain\Event\TrackCreated;
use Track\Domain\ValueObject\CreatorId;
use Track\Domain\ValueObject\OwnerId;
use Track\Domain\ValueObject\TrackAccessType;
use Track\Domain\ValueObject\TrackName;
use Track\Domain\ValueObject\TrackPath;

class Track extends Aggregate implements \Common\Domain\Entity\Port\Aggregate
{

    private OwnerId         $ownerId;
    private TrackName       $trackName;
    private TrackAccessType $trackAccessType;
    private TrackPath       $trackPath;

    /**
     * @param OwnerId $creatorId
     * @param TrackName $trackName
     * @param TrackAccessType $trackAccessType
     * @param TrackPath $trackPath
     * @return Track
     * @throws InvalidUuidException
     */
    public static function create(
        OwnerId         $ownerId,
        TrackName       $trackName,
        TrackAccessType $trackAccessType,
        TrackPath       $trackPath,
    ): Track
    {
        $instance     = new static();
        $instance->id = Uuid::create();

        $event = new TrackCreated(
            $ownerId,
            $trackName,
            $trackAccessType,
            $trackPath,
        );
        $event->setAggregateId($instance->getId());
        $instance->recordThat($event);

        return $instance;
    }

    /**
     * @param TrackCreated $event
     * @return void
     */
    public function onTrackCreated(TrackCreated $event): void
    {
        $this->ownerId         = $event->ownerId;
        $this->trackName       = $event->trackName;
        $this->trackAccessType = $event->trackAccessType;
        $this->trackPath       = $event->trackPath;
    }
}