<?php

namespace Ride\Domain\ValueObject;

use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Common\Domain\ValueObject\GeoLocationValue;
use Common\Domain\ValueObject\TextValue;
use Common\Domain\ValueObject\ValueObject;

class RideLocationStart extends ValueObject
{
    private TextValue $description;

    private GeoLocationValue $startLocation;

    /**
     * @throws InvalidStringLengthException
     */
    public function __construct(string $description, float $lat, float $lon)
    {
        $this->description   = new TextValue($description);
        $this->startLocation = new GeoLocationValue($lat, $lon);
    }

    public function getDescription(): TextValue
    {
        return $this->description;
    }

    public function getStartLocation(): GeoLocationValue
    {
        return $this->startLocation;
    }

    #[\Override] public function toString(): string
    {
        // TODO: Implement toString() method.
    }
}