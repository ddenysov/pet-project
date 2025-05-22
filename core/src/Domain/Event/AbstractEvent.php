<?php

declare(strict_types=1);

namespace Zinc\Core\Domain\Event;

use Zinc\Core\Domain\Value\Uuid;

abstract class AbstractEvent implements Event
{
    /**
     * Uniq event identifier
     * - help with deduplication
     * - tracing
     * - uniq in event store
     */
    public Uuid $id;

    /**
     * Aggregate produced this event
     */
    public Uuid $aggregateId;

    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @throws \Exception
     */
    public function toArray(): array {}

    public function getAggregateId(): Uuid
    {
        return $this->aggregateId;
    }
}
