<?php

namespace Common\Application\EventStore\Port;

use Common\Domain\Event\Port\EventCollection;

interface EventStore
{
    /**
     * @param EventCollection $events
     * @return EventStore
     */
    public function append(EventCollection $events): EventStore;
}