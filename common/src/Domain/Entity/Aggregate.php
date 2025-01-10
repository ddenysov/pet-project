<?php

namespace Common\Domain\Entity;


use Common\Domain\Event\Port\EventStream;
use Common\Domain\Event\Port\Event;
use Common\Domain\ValueObject\Uuid;

abstract class Aggregate extends Entity implements Port\Aggregate
{
    /**
     * @var EventStream
     */
    protected EventStream $events;

    /**
     * @param Uuid $id
     */
    final protected function __construct(Uuid $id)
    {
        $this->id = $id;
        $this->events = new \Common\Domain\Event\EventStream();
    }

    /**
     * @return array|EventStream
     */
    public function releaseEvents(): EventStream
    {
        $events = $this->events;
        $this->events = new \Common\Domain\Event\EventStream();

        return $events;
    }

    public function uncommittedEvents(): array
    {
        return $this->events;
    }

    /**
     * @param Event $event
     * @return void
     */
    public function recordThat(Event $event): static
    {
        if ($this->getId()) {
            $event->setAggregateId($this->getId());
        }
        $this->apply($event);
        $this->events[] = $event;

        return $this;
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