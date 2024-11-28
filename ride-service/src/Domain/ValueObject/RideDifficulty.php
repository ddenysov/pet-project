<?php

namespace Ride\Domain\ValueObject;

use Common\Domain\ValueObject\Uuid;

final class RideDifficulty
{
    private const LOW = 'low';
    private const MEDIUM = 'medium';
    private const HIGH = 'high';

    private const ALLOWED_DIFFICULTY_LEVELS = [
        self::LOW,
        self::MEDIUM,
        self::HIGH,
    ];

    private string $value;

    private function __construct(string $value)
    {
        if (!in_array($value, self::ALLOWED_DIFFICULTY_LEVELS, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid difficulty level: %s', $value));
        }

        $this->value = $value;
    }

    public static function low(): self
    {
        return new self(self::LOW);
    }

    public static function medium(): self
    {
        return new self(self::MEDIUM);
    }

    public static function high(): self
    {
        return new self(self::HIGH);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function equals(RideDifficulty $other): bool
    {
        return $this->value === $other->value;
    }
}