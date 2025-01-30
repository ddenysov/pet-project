<?php

namespace Common\Domain\ValueObject;

use Common\Domain\ValueObject\Port\SerializableValue;

abstract class ValueObject implements \Common\Domain\ValueObject\Port\StringValue, SerializableValue
{
    /**
     * @return string
     */
    abstract public function toString(): string;

    /**
     * @param ValueObject $object
     * @return bool
     */
    public function equals(ValueObject $object): bool
    {
        return $this->toString() === $object->toString();
    }

    /**
     * @param ValueObject $object
     * @return bool
     */
    public function notEquals(ValueObject $object): bool
    {
        return !$this->equals($object);
    }

    /**
     * @param string $value
     * @return static
     */
    public static function deserialize(string $value): static
    {
        return new static($value);
    }

    /**
     * @return string
     */
    public function serialize(): string
    {
        return $this->toString();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}