<?php

namespace Zinc\Core\Domain\Aggregate;

use Zinc\Core\Domain\Event\EventInterface;
use Zinc\Core\Domain\Event\EventStreamInterface;

interface AggregateRootInterface
{
    /** Rebuild from history */
    public static function restore(EventStreamInterface $events): static;

    /** Flush and return uncommitted events */
    public function releaseEvents(): EventStreamInterface;

    /** Peek uncommitted events without flushing */
    public function uncommittedEvents(): EventStreamInterface;

    /** Record + apply a new domain event */
    public function recordThat(EventInterface $event): static;

    /** Optimistic-locking helpers */
    public function getVersion(): int;
    public function getPreviousVersion(): int;
}