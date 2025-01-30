<?php

namespace Common\Application\EventStore\Port;

use Common\Domain\Event\Port\Event;
use Common\Domain\Event\Port\EventStream;
use Common\Domain\ValueObject\Uuid;

interface EventStore
{
    /**
     * @param Event $event
     * @return EventStore
     */
    public function append(EventStream|Event $events): EventStore;

    /**
     * @param Uuid $id
     * @return EventStream
     */
    public function load(Uuid $id): EventStream;
}