<?php

namespace Zinc\Core\Domain\Entity;

use Zinc\Core\Domain\Value\Uuid;
use Zinc\Core\Support\Array\AsArray;

/**
 * Entity simple object. There are no EventSourcing stuff like sending events etc
 */
abstract class Entity implements AsArray
{
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
        return [];
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }
}