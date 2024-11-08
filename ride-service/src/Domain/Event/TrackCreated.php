<?php

namespace Ride\Domain\Event;

use Common\Domain\Event\Event;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Ride\Domain\ValueObject\OwnerId;
use Ride\Domain\ValueObject\TrackAccessType;
use Ride\Domain\ValueObject\TrackName;
use Ride\Domain\ValueObject\TrackPath;

class TrackCreated extends Event
{
    public readonly OwnerId         $ownerId;
    public readonly TrackName       $trackName;
    public readonly TrackAccessType $trackAccessType;
    public readonly TrackPath       $trackPath;

    /**
     * @param OwnerId $creatorId
     * @param TrackName $trackName
     * @param TrackAccessType $trackAccessType
     * @param TrackPath $trackPath
     * @throws InvalidUuidException
     */
    public function __construct(OwnerId $ownerId, TrackName $trackName, TrackAccessType $trackAccessType, TrackPath $trackPath)
    {
        $this->ownerId         = $ownerId;
        $this->trackName       = $trackName;
        $this->trackAccessType = $trackAccessType;
        $this->trackPath       = $trackPath;
        parent::__construct();
    }
}