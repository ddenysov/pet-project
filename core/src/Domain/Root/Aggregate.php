<?php

namespace Zinc\Core\Domain\Root;


use Zinc\Core\Domain\Entity\Entity;
use Zinc\Core\Domain\Event\Event;
use Zinc\Core\Domain\Event\EventStream;
use Zinc\Core\Domain\Value\Uuid;

abstract class Aggregate extends Entity
{
    /**
     * @var EventStream
     */
    protected EventStream $events;

    /**
     * @var int
     */
    private int $version = 0;

    /**
     * @param Uuid $id
     */
    final protected function __construct()
    {
        $this->events = new EventStream();
    }

    /**
     * @return EventStream
     */
    public function releaseEvents(): EventStream
    {
        $events       = $this->events;
        $this->events = new EventStream();

        return $events;
    }

    public function uncommittedEvents(): EventStream
    {
        return $this->events;
    }

    /**
     * @param Event $event
     * @return Aggregate
     */
    public function recordThat(Event $event): static
    {
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
        $parts  = explode('\\', $event::class);
        $method = 'on' . array_pop($parts);

        $this->$method($event);
        $this->bumpVersion();

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

    private function bumpVersion(): void
    {
        $this->version = $this->version + 1;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function getPreviousVersion(): int
    {
        return $this->getVersion() - count($this->events);
    }
}