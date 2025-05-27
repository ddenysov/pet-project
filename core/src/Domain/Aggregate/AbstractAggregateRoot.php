<?php

declare(strict_types=1);

namespace Zinc\Core\Domain\Aggregate;

use Zinc\Core\Domain\Entity\AbstractEntity;
use Zinc\Core\Domain\Event\EventInterface;
use Zinc\Core\Domain\Event\EventStream;
use Zinc\Core\Domain\Event\EventStreamInterface;

abstract class AbstractAggregateRoot extends AbstractEntity implements AggregateRootInterface
{
    protected EventStream $events;

    private int $version = 0;

    final protected function __construct()
    {
        $this->events = new EventStream();
    }

    /**
     * @param EventStream $events
     * @return AbstractAggregateRoot
     */
    public static function restore(EventStreamInterface $events): static
    {
        $aggregate = new static();
        foreach ($events as $event) {
            $aggregate->apply($event);
        }

        return $aggregate;
    }

    public function releaseEvents(): EventStreamInterface
    {
        $events       = $this->events;
        $this->events = new EventStream();

        return $events;
    }

    public function uncommittedEvents(): EventStreamInterface
    {
        return $this->events;
    }

    /**
     * @param EventInterface $event
     * @return AbstractAggregateRoot
     */
    public function recordThat(EventInterface $event): static
    {
        $this->apply($event);
        $this->events[] = $event;

        return $this;
    }

    /**
     * @return $this
     */
    public function apply(EventInterface $event): static
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
