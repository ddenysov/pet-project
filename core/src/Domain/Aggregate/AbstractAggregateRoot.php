<?php

declare(strict_types=1);

namespace Zinc\Core\Domain\Aggregate;

use Zinc\Core\Domain\Entity\Entity;
use Zinc\Core\Domain\Event\Event;
use Zinc\Core\Domain\Event\EventStream;

abstract class AbstractAggregateRoot extends Entity
{
    protected EventStream $events;

    private int $version = 0;

    final protected function __construct()
    {
        $this->events = new EventStream();
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
     * @return Aggregate
     */
    public function recordThat(Event $event): static
    {
        $this->apply($event);
        $this->events[] = $event;

        return $this;
    }

    /**
     * @return $this
     */
    public function apply(Event $event): static
    {
        $parts  = \explode('\\', $event::class);
        $method = 'on' . \array_pop($parts);

        $this->$method($event);
        $this->bumpVersion();

        return $this;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function getPreviousVersion(): int
    {
        return $this->getVersion() - \count($this->events);
    }

    private function bumpVersion(): void
    {
        $this->version = $this->version + 1;
    }
}
