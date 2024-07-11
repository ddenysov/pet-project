<?php

namespace Common\Domain\Entity;

abstract class Entity implements Port\Primary\Entity
{
    final public function toArray(): array
    {
        return [
            'id' => $this->getId()->toString(),
            ...$this->serialize(),
        ];
    }

    protected function serialize(): array
    {
        return [];
    }
}