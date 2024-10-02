<?php

namespace Common\Domain\ValueObject\Port;

interface SerializableValue
{
    /**
     * @param string $value
     * @return static
     */
    public static function deserialize(string $value): static;
}