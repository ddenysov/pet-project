<?php

namespace Common\Application\EventPublisher;

use Common\Domain\ValueObject\Uuid;

class Event
{
    public function __construct(
        private Uuid $eventId,
        private Uuid $aggregateId,
        private  string $eventName,
        private array $payload
    )
    {
    }

    public function getEventId(): Uuid
    {
        return $this->eventId;
    }

    public function getAggregateId(): Uuid
    {
        return $this->aggregateId;
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }
}