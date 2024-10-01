<?php

namespace Common\Domain\ValueObject;

use DateTimeImmutable;
use DateTimeInterface;

class DateTimeValue extends ValueObject
{
    private DateTimeInterface $value;

    /**
     * @param DateTimeImmutable $value
     */
    public function __construct(DateTimeInterface $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value->format('Y-m-d H:i:s');
    }
}