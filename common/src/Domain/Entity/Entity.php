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
     * @param mixed ...$args
     * @return static
     * @throws InvalidUuidException
     */
    public static function create(...$args): static
    {
        return new static(Uuid::create(), $args);
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }
}