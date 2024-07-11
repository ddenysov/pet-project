<?php

namespace Common\Domain\ValueObject\Exception;

class InvalidStringException extends InvalidValueException
{
    /**
     * @throws InvalidUuidException
     */
    public static function invalidString(string $value): void
    {
        throw new self('Invalid UUID: ' . $value);
    }
}