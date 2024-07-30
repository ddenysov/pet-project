<?php

namespace Common\Domain\Entity\Port;

use Common\Domain\Event\Port\Event;
use Common\Domain\Event\Port\EventCollection;

interface Aggregate extends Entity
{
    public function releaseEvents(): array;

    /**
     * @param Event $event
     * @return void
     */
    public function recordThat(Event $event): void;
}