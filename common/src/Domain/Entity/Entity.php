<?php

namespace Common\Domain\Entity;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Uuid;
use Common\Domain\ValueObject\ValueObject;
use Common\Utils\Serialize\Trait\ObjectToArray;

/**
 * Entity simple object. There are no EventSourcing stuff like sending events etc
 */
abstract class Entity implements Port\Entity
{
    use ObjectToArray;

    /**
     * @var Uuid
     */
    protected Uuid $id;

    /**
     * Convert aggregate to array
     * Q: Do I need to implement serialize method ?
     * @return array
     * @throws \Exception
     */
    final public function toArray(): array
    {
        return $this->propertiesToArray();
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }
}