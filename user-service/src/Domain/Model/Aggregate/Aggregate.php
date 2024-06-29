<?php

namespace User\Domain\Model\Aggregate;

use User\Domain\Model\Event\DomainEvent;

abstract class Aggregate
{
    /**
     * @var array
     */
    protected array $events = [];

    /**
     * @param DomainEvent $event
     * @return void
     */
    public function record(DomainEvent $event)
    {
        $this->events[] = $event;
    }

    /**
     * @return DomainEvent[]
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}