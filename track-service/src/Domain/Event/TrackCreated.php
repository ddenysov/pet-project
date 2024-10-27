<?php

namespace Track\Domain\Event;

use Common\Domain\Event\Event;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Track\Domain\ValueObject\CreatorId;
use Track\Domain\ValueObject\OwnerId;
use Track\Domain\ValueObject\TrackAccessType;
use Track\Domain\ValueObject\TrackName;
use Track\Domain\ValueObject\TrackPath;

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
    public function __construct(OwnerId $creatorId, TrackName $trackName, TrackAccessType $trackAccessType, TrackPath $trackPath)
    {
        $this->ownerId         = $creatorId;
        $this->trackName       = $trackName;
        $this->trackAccessType = $trackAccessType;
        $this->trackPath       = $trackPath;
        parent::__construct();
    }
}