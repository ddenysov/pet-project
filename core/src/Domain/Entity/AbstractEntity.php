<?php

declare(strict_types=1);

namespace Zinc\Core\Domain\Entity;

use Zinc\Core\Domain\Value\Uuid;
use Zinc\Core\Domain\Value\UuidInterface;
use Zinc\Core\Support\Array\AsArray;

/**
 * Entity simple object. There are no EventSourcing stuff like sending events etc
 */
abstract class AbstractEntity implements AsArray
{
    protected UuidInterface $id;

    /**
     * Convert aggregate to array
     * Q: Do I need to implement serialize method ?
     * @throws \Exception
     */
    final public function toArray(): array
    {
        return [];
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }
}
