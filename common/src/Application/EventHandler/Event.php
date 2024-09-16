<?php

namespace Common\Application\EventHandler;

use Common\Domain\ValueObject\Uuid;

class Event
{
    public function __construct(
        private Uuid $eventId,
        private  string $eventName,
        private array $payload
    )
    {
    }

    public function getEventId(): Uuid
    {
        return $this->eventId;
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }

    public function getEventClass(): string
    {
        $parts = explode('.', $this->getEventName());
        $parts = array_map(function ($input) {
            return str_replace('_', '', ucwords($input, '_'));
        }, $parts);

        return implode('\\', $parts);
    }

    public function getPayload(): array
    {
        return $this->payload;
    }
}