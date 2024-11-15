<?php

namespace Common\Domain\ValueObject;

use DateTime;
use DateTimeInterface;
use Exception;

class DateTimeValue extends ValueObject
{
    private DateTimeInterface $value;

    /**
     * @param DateTimeInterface|string $value
     * @throws Exception
     */
    public function __construct(DateTimeInterface|string $value)
    {
        if (is_string($value)) {
            $value = new DateTime($value);
        }
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value->format('Y-m-d H:i:s');
    }

    /**
     * @throws Exception
     */
    public static function now()
    {
        return new static(new DateTime());
    }
}