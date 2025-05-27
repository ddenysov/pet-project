<?php

declare(strict_types=1);

namespace Zinc\Core\Domain\Event;

use Zinc\Core\Domain\Value\Uuid;
use Zinc\Core\Domain\Value\UuidInterface;

abstract class AbstractEvent implements EventInterface
{
    /**
     * Uniq event identifier
     * - help with deduplication
     * - tracing
     * - uniq in event store
     */
    public UuidInterface $id;

    /**
     * Aggregate produced this event
     */
    public UuidInterface $aggregateId;

    public function __construct(UuidInterface $aggregateId)
    {
        $this->aggregateId = $aggregateId;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @throws \Exception
     */
    public function toArray(): array {}

    public function getAggregateId(): UuidInterface
    {
        return $this->aggregateId;
    }
}
