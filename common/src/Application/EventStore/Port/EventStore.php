<?php

namespace Common\Application\EventStore\Port;

use Common\Domain\Event\Event;

interface EventStore
{
    /**
     * @param Event $event
     * @return EventStore
     */
    public function append(Event $event): EventStore;
}