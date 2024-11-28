<?php

namespace Ride\Domain\ValueObject;

use Common\Domain\ValueObject\Uuid;

final class RideAccess
{
    private const PUBLIC = 'public';
    private const PRIVATE = 'private';

    private const ALLOWED_ACCESS_TYPES = [
        self::PUBLIC,
        self::PRIVATE,
    ];

    private string $value;

    private function __construct(string $value)
    {
        if (!in_array($value, self::ALLOWED_ACCESS_TYPES, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid access type: %s', $value));
        }

        $this->value = $value;
    }

    public static function public(): self
    {
        return new self(self::PUBLIC);
    }

    public static function private(): self
    {
        return new self(self::PRIVATE);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function equals(RideAccess $other): bool
    {
        return $this->value === $other->value;
    }
}