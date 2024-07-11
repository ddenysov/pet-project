<?php

namespace Common\Domain\ValueObject\Exception;

class InvalidUuidException extends InvalidValueException
{
    /**
     * @throws InvalidUuidException
     */
    public static function invalidUuid(string $value): void
    {
        throw new self('Invalid UUID: ' . $value);
    }
}