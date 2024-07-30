<?php

namespace Common\Domain\ValueObject;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Infrastructure\Uuid\Symfony\UuidAdapter;

class Uuid extends ValueObject implements Port\StringValue
{
    /**
     * @var string
     */
    private string $uuid;

    /**
     * @param string $uuid
     * @throws InvalidUuidException
     */
    public function __construct(string $uuid)
    {
        if (!UuidAdapter::isValid($uuid)) {
            InvalidUuidException::invalidUuid($uuid);
        }

        $this->uuid = $uuid;
    }

    /**
     * @return self
     * @throws InvalidUuidException
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

    /**
     * @throws InvalidUuidException
     */
    public static function fromUuid(self $uuid)
    {
        return new static($uuid->toString());
    }

    /**
     * @throws InvalidUuidException
     */
    public function toUuid(): self
    {
        return new self($this->uuid);
    }
}