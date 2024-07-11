<?php

namespace Common\Domain\ValueObject;

use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;

class StringValue extends ValueObject
{
    protected string $value;

    /**
     * @throws InvalidStringLengthException
     */
    public function __construct(string $value)
    {
        if (strlen($value) > $this->getMaxLength()) {
            throw new InvalidStringLengthException();
        }

        if (strlen($value) < $this->getMinLength()) {
            throw new InvalidStringLengthException();
        }

        $this->value = $value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function getMaxLength(): int
    {
        return 255;
    }

    public function getMinLength(): int
    {
        return 0;
    }
}