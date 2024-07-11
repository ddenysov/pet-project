<?php

namespace Common\Domain\ValueObject;

use Common\Infrastructure\Uuid\Symfony\UuidAdapter;

class Uuid extends ValueObject
{
    /**
     * @param string $uuid
     */
    public function __construct(private string $uuid)
    {
    }

    /**
     * @return self
     */
    public static function create(): static
    {
        return new static(UuidAdapter::create());
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->uuid;
    }
}