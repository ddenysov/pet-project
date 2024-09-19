<?php

namespace Common\Domain\Entity;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Uuid;

abstract class Entity implements Port\Entity
{
    /**
     * @var Uuid
     */
    protected $id;

    final protected function __construct()
    {
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

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @param Uuid $id
     * @return void
     */
    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }
}