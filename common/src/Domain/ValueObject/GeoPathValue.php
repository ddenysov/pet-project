<?php

namespace Common\Domain\ValueObject;

use Common\Domain\ValueObject\Port\ArrayValue;

class GeoPathValue extends ValueObject implements ArrayValue
{
    public function __construct(protected array $path)
    {
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return json_encode($this->path);
    }

    public function toArray(): array
    {
        return $this->path;
    }

    /**
     * @param string $value
     * @return static
     */
    public static function deserialize(string $value): static
    {
        $path = json_decode($value, true);

        return new static($path);
    }

    /**
     * @return string
     */
    public function serialize(): string
    {
        return json_encode($this->toArray());
    }
}