<?php

namespace User\Domain\Model\ValueObject;

readonly class UserName
{
    /**
     * @param string $value
     */
    public function __construct(private string $value)
    {
    }

    public function toString(): string
    {
        return $this->value;
    }
}