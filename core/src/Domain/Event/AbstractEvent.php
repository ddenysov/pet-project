<?php

namespace Zinc\Core\Domain\Event;

use Zinc\Core\Domain\Value\Uuid;

abstract class AbstractEvent implements Event
{
    /**
     * Uniq event identifier
     * - help with deduplication
     * - tracing
     * - uniq in event store
     * @var Uuid
     */
    public Uuid $id;

    /**
     * Aggregate produced this event
     * @var Uuid
     */
    public Uuid $aggregateId;

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function toArray(): array
    {

    }

    /**
     * @return Uuid
     */
    public function getAggregateId(): Uuid
    {
        return $this->aggregateId;
    }
}