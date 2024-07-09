<?php

namespace Common\Domain\ValueObject;

class StringValue extends ValueObject
{

    public function __construct(private string $value)
    {
    }

    public function toString(): string
    {
        return $this->value;
    }

    protected function validate(): void
    {

    }
}