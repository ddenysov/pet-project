<?php

namespace Ride\Domain\ValueObject;

use Common\Domain\ValueObject\Uuid;

final class RideRegistrationType
{
    private const FREE = 'free';
    private const CONFIRMATION = 'confirmation';

    private const ALLOWED_REGISTRATION_TYPES = [
        self::FREE,
        self::CONFIRMATION,
    ];

    private string $value;

    private function __construct(string $value)
    {
        if (!in_array($value, self::ALLOWED_REGISTRATION_TYPES, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid registration type: %s', $value));
        }

        $this->value = $value;
    }

    public static function free(): self
    {
        return new self(self::FREE);
    }

    public static function confirmation(): self
    {
        return new self(self::CONFIRMATION);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function equals(RideRegistrationType $other): bool
    {
        return $this->value === $other->value;
    }
}