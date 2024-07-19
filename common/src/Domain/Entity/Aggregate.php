<?php

namespace Common\Domain\Entity;


use Common\Domain\Event\Port\Event;
use User\Domain\Model\Event\DomainEvent;

abstract class Aggregate extends Entity implements Port\Aggregate
{
    /**
     * @var array
     */
    protected array $events = [];

    /**
     * @return DomainEvent[]
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }

    /**
     * @param Event $event
     * @return void
     */
    public function recordThat(Event $event): void
    {
        $this->events[] = $event;
    }
}