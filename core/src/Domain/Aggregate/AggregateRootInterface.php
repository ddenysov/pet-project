<?php

namespace Zinc\Core\Domain\Aggregate;

interface AggregateRootInterface
{
    /** Rebuild from history */
    public static function restore(EventStream $events): static;

    /** Flush and return uncommitted events */
    public function releaseEvents(): EventStream;

    /** Peek uncommitted events without flushing */
    public function uncommittedEvents(): EventStream;

    /** Record + apply a new domain event */
    public function recordThat(Event $event): static;

    /** Optimistic-locking helpers */
    public function getVersion(): int;
    public function getPreviousVersion(): int;
}