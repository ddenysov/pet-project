<?php

declare(strict_types=1);

namespace Zinc\Core\Domain\Value;

use Symfony\Component\Uid\UuidV4;
use Zinc\Core\Support\String\AsString;

class Uuid extends AbstractValue implements ValueInterface
{
    public function __construct(private string $value) {}

    public static function create(): static
    {
        return new static(UuidV4::v4()->toString());
    }

    public static function fromString(string $uuid): self
    {
        return new self($uuid);
    }

    public function toString(): string
    {
        return $this->value;
    }
}
