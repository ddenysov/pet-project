<?php

namespace Common\Domain\Entity;


use Common\Domain\Event\Port\Event;
use Common\Domain\Event\Port\EventCollection;
use User\Domain\Model\Event\DomainEvent;

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

    /**
     * @return DomainEvent[]
     */
    public function releaseEvents(): EventCollection
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
        $event->setId($this->id);
        $this->apply($event);
        $this->events[] = $event;
    }

    public function apply(Event $event): static
    {
        if (isset(static::$subscribers[$event::class])) {
            foreach (static::$subscribers[$event::class] as $subscriberMethod) {
                $this->$subscriberMethod($event);
            }
        }
    }
}