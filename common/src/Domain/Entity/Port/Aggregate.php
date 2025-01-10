<?php

namespace Common\Domain\Entity\Port;

use Common\Domain\Event\Port\EventStream;
use Common\Domain\Event\Port\Event;
use Common\Domain\Event\Port\EventCollection;

interface Aggregate extends Entity
{
    /**
     * @return array
     */
    public function releaseEvents(): EventStream;

    /**
     * @return array
     */
    public function uncommittedEvents(): array;

    /**
     * @param Event $event
     * @return void
     */
    public function recordThat(Event $event): static;

    /**
     * @param EventStream $events
     * @return $this
     */
    public static function restore(EventStream $events): static;
}