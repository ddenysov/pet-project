<?php

namespace Ride\Domain\ValueObject;

use Common\Domain\ValueObject\Uuid;

final class RideStatus
{
    private const  DRAFT     = 'draft';
    private const  PUBLISHED = 'published';
    private const  COMPLETED = 'completed';

    private const ALLOWED_STATUSES = [
        self::DRAFT,
        self::PUBLISHED,
        self::COMPLETED,
    ];

    private string $value;

    /**
     * @param string $value
     */
    private function __construct(string $value)
    {
        if (!in_array($value, self::ALLOWED_STATUSES, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid status: %s', $value));
        }

        $this->value = $value;
    }

    public static function draft(): self
    {
        return new self(self::DRAFT);
    }

    public static function published(): self
    {
        return new self(self::PUBLISHED);
    }

    public static function completed(): self
    {
        return new self(self::COMPLETED);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function equals(Status $other): bool
    {
        return $this->value === $other->value;
    }
}