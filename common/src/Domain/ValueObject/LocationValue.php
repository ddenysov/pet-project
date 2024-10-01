<?php

namespace Common\Domain\ValueObject;

use Common\Domain\ValueObject\Port\ArrayValue;

class LocationValue extends ValueObject implements ArrayValue
{
    /**
     * @var float
     */
    protected float $lat;

    /**
     * @var float
     */
    protected float $lon;

    /**
     * @param float $lat
     * @param float $lon
     */
    public function __construct(float $lat, float $lon)
    {
        $this->lat = $lat;
        $this->lon = $lon;
    }

    /**
     * @param array $location
     * @return static
     */
    public static function fromArray(array $location): static
    {
        return new static($location[0], $location[1]);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->lat . ',' . $this->lon;
    }

    public function toArray(): array
    {
        return [
            'lat' => $this->lat,
            'lon' => $this->lon,
        ];
    }

    public function getLat(): float
    {
        return $this->lat;
    }

    public function getLon(): float
    {
        return $this->lon;
    }
}