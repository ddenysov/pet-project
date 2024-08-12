<?php

namespace Common\Application\EventStore\Port;

use Common\Domain\Event\Event;
use Common\Domain\Event\EventStream;
use Common\Domain\ValueObject\Uuid;

interface EventStore
{
    /**
     * @param Event $event
     * @return EventStore
     */
    public function append(Event $event): EventStore;

    public function getEventStream(Uuid $id): EventStream;
}