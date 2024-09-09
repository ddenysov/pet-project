<?php

namespace Common\Domain\ValueObject;

abstract class ValueObject
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
}