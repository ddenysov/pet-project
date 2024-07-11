<?php

namespace Common\Domain\Entity;

use Common\Domain\ValueObject\Uuid;

abstract class Entity implements Port\Primary\Entity
{
    protected $id;

    public function __construct(Uuid $id)
    {
        $this->id = $id;
    }

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