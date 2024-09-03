<?php

namespace Common\Domain\Entity;


use Common\Domain\Event\EventStream;
use Common\Domain\Event\Port\Event;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Uuid;

abstract class Aggregate extends Entity implements Port\Aggregate
{
    /**
     * @var array
     */
    protected array $events = [];

    /**
     * @var array
     */
    protected static array $subscribers = [];

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
        if ($this->getId()) {
            $event->setAggregateId($this->getId());
        }
        $this->apply($event);
        $this->events[] = $event;
    }

    /**
     * @param Event $event
     * @return $this
     */
    public function apply(Event $event): static
    {
        $parts = explode('\\', $event::class);
        $method = 'on' . array_pop($parts);

        $this->$method($event);

        return $this;
    }

    /**
     * @param EventStream $events
     * @return Aggregate
     */
    public static function restore(EventStream $events): static
    {
        $aggregate = new static();
        foreach ($events as $event) {
            $aggregate->apply($event);
        }

        return $aggregate;
    }
}