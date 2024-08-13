<?php

namespace Common\Domain\Entity;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Uuid;
use User\Domain\Model\Event\DomainEvent;

abstract class Entity implements Port\Entity
{
    /**
     * @var Uuid
     */
    protected $id;

    public function __construct(Uuid $id = null)
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

    /**
     * @param mixed ...$args
     * @return static
     * @throws InvalidUuidException
     */
    public static function create(...$args): static
    {
        return new static(Uuid::create(), $args);
    }
}