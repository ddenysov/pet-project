<?php

namespace Common\Domain\ValueObject;

use Common\Domain\ValueObject\Port\ArrayValue;

class GeoLocationValue extends ValueObject implements ArrayValue
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

    /**
     * @param string $value
     * @return static
     */
    public static function deserialize(string $value): static
    {
        $location = json_decode($value, true);

        return new static($location['lat'], $location['lon']);
    }

    /**
     * @return string
     */
    public function serialize(): string
    {
        return json_encode($this->toArray());
    }
}