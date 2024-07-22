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
     * @var array
     */
    protected static array $subscribers = [];

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
        $event->setId($this->id);
        if (isset(static::$subscribers[$event::class])) {
            foreach (static::$subscribers[$event::class] as $subscriberMethod) {
                $this->$subscriberMethod($event);
            }
        }
        $this->events[] = $event;
    }
}