<?php

namespace Ride\Domain\ValueObject;

use Common\Domain\ValueObject\Uuid;

final class RideBikeType
{
    private const GRAVEL = 'gravel';
    private const MTB = 'mtb';
    private const ROAD = 'road';
    private const ANY = 'any';

    private const ALLOWED_BIKE_TYPES = [
        self::GRAVEL,
        self::MTB,
        self::ROAD,
        self::ANY,
    ];

    private string $value;

    private function __construct(string $value)
    {
        if (!in_array($value, self::ALLOWED_BIKE_TYPES, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid bike type: %s', $value));
        }

        $this->value = $value;
    }

    public static function gravel(): self
    {
        return new self(self::GRAVEL);
    }

    public static function mtb(): self
    {
        return new self(self::MTB);
    }

    public static function road(): self
    {
        return new self(self::ROAD);
    }

    public static function any(): self
    {
        return new self(self::ANY);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function equals(RideBikeType $other): bool
    {
        return $this->value === $other->value;
    }
}